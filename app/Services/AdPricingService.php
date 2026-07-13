<?php

namespace App\Services;

use App\Models\AdPrice;
use App\Models\AdType;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Support\AdTargeting;

/**
 * Prices a target against the admin's rate card.
 *
 * Every targeted place is priced on its own, using the most specific rate the
 * admin has entered and falling back outwards when there isn't one:
 *
 *     city -> its region -> its province -> country
 *
 * So an admin can set one country-wide rate per ad type and be done, then
 * override individual provinces, regions or cities as needed. A place with no
 * rate anywhere up the chain is reported in `unpriced` rather than priced at
 * zero, so nobody is quoted a free ad by accident.
 */
class AdPricingService
{
    /**
     * @param  array<string, mixed>  $target  Scope + province/region/city IDs, as stored.
     * @param  int|null  $days  Campaign length, when quoting a real date range.
     * @return array{
     *     ad_type: ?string,
     *     currency: string,
     *     lines: array<int, array{label: string, price: float, unit: string, matched_scope: string}>,
     *     unpriced: array<int, string>,
     *     totals_by_unit: array<string, float>,
     *     days: ?int,
     *     estimated_total: ?float
     * }
     */
    public function quote(int|string|null $adTypeId, array $target, ?int $days = null): array
    {
        $adType = filled($adTypeId) ? AdType::find($adTypeId) : null;

        $empty = [
            'ad_type' => $adType?->name,
            'currency' => 'CAD',
            'lines' => [],
            'unpriced' => [],
            'totals_by_unit' => [],
            'days' => $days,
            'estimated_total' => null,
        ];

        if (! $adType || blank($target['target_scope'] ?? null)) {
            return $empty;
        }

        $prices = $this->rateCardFor($adType->id);
        $lines = [];
        $unpriced = [];

        foreach ($this->placesIn($target) as $place) {
            $match = $this->resolve($prices, $place);

            if ($match === null) {
                $unpriced[] = $place['label'];

                continue;
            }

            $lines[] = [
                'label' => $place['label'],
                'price' => (float) $match->price,
                'unit' => $match->unit,
                'matched_scope' => $match->scope,
            ];
        }

        $totals = [];
        foreach ($lines as $line) {
            $totals[$line['unit']] = ($totals[$line['unit']] ?? 0.0) + $line['price'];
        }

        return [
            'ad_type' => $adType->name,
            'currency' => $lines ? ($prices->first()->currency ?? 'CAD') : 'CAD',
            'lines' => $lines,
            'unpriced' => $unpriced,
            'totals_by_unit' => $totals,
            'days' => $days,
            'estimated_total' => $days !== null ? $this->totalOver($lines, $days) : null,
        ];
    }

    /**
     * Cost of the quoted lines across a campaign of `$days` days.
     *
     * @param  array<int, array{price: float, unit: string}>  $lines
     */
    public function totalOver(array $lines, int $days): float
    {
        $days = max($days, 1);
        $total = 0.0;

        foreach ($lines as $line) {
            $unitDays = AdPrice::unitDays($line['unit']);

            // A flat rate is charged once, however long the campaign runs.
            $units = $unitDays === null ? 1 : (int) ceil($days / $unitDays);

            $total += $line['price'] * $units;
        }

        return round($total, 2);
    }

    /**
     * Active rates for one ad type, with locations eager-loaded.
     */
    protected function rateCardFor(int $adTypeId): \Illuminate\Support\Collection
    {
        return AdPrice::query()
            ->where('ad_type_id', $adTypeId)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Expand a target into the individual places that each need a rate.
     *
     * @param  array<string, mixed>  $target
     * @return array<int, array{label: string, scope: string, province_id: ?int, region_id: ?int, city_id: ?int}>
     */
    protected function placesIn(array $target): array
    {
        $scope = $target['target_scope'];
        $provinceIds = array_map('intval', (array) ($target['target_province_ids'] ?? []));
        $regionIds = array_map('intval', (array) ($target['target_region_ids'] ?? []));
        $cityIds = array_map('intval', (array) ($target['target_city_ids'] ?? []));

        if ($scope === AdTargeting::SCOPE_COUNTRY) {
            return [[
                'label' => AdTargeting::countryLabel(),
                'scope' => AdTargeting::SCOPE_COUNTRY,
                'province_id' => null,
                'region_id' => null,
                'city_id' => null,
            ]];
        }

        if ($scope === AdTargeting::SCOPE_REGION) {
            return Region::query()->with('province')->whereIn('id', $regionIds)->orderBy('name')->get()
                ->map(fn (Region $region): array => [
                    'label' => $region->name.', '.$region->province?->name,
                    'scope' => AdTargeting::SCOPE_REGION,
                    'province_id' => (int) $region->province_id,
                    'region_id' => (int) $region->id,
                    'city_id' => null,
                ])->all();
        }

        if ($scope === AdTargeting::SCOPE_CITY) {
            return City::query()->with('province')->whereIn('id', $cityIds)->orderBy('name')->get()
                ->map(fn (City $city): array => [
                    'label' => $city->name.', '.$city->province?->name,
                    'scope' => AdTargeting::SCOPE_CITY,
                    'province_id' => (int) $city->province_id,
                    'region_id' => $city->region_id ? (int) $city->region_id : null,
                    'city_id' => (int) $city->id,
                ])->all();
        }

        // Province-wide and multi-province: one line per province.
        return Province::query()->whereIn('id', $provinceIds)->orderBy('name')->get()
            ->map(fn (Province $province): array => [
                'label' => $province->name.' (province-wide)',
                'scope' => AdTargeting::SCOPE_PROVINCE,
                'province_id' => (int) $province->id,
                'region_id' => null,
                'city_id' => null,
            ])->all();
    }

    /**
     * Most specific rate that covers this place, or null if the admin has not
     * priced it at any level.
     *
     * @param  \Illuminate\Support\Collection<int, AdPrice>  $prices
     * @param  array{scope: string, province_id: ?int, region_id: ?int, city_id: ?int}  $place
     */
    protected function resolve(\Illuminate\Support\Collection $prices, array $place): ?AdPrice
    {
        $candidates = [];

        if ($place['city_id']) {
            $candidates[] = fn (AdPrice $p): bool => $p->scope === AdTargeting::SCOPE_CITY
                && (int) $p->city_id === $place['city_id'];
        }

        if ($place['region_id']) {
            $candidates[] = fn (AdPrice $p): bool => $p->scope === AdTargeting::SCOPE_REGION
                && (int) $p->region_id === $place['region_id'];
        }

        if ($place['province_id']) {
            $candidates[] = fn (AdPrice $p): bool => $p->scope === AdTargeting::SCOPE_PROVINCE
                && (int) $p->province_id === $place['province_id'];
        }

        $candidates[] = fn (AdPrice $p): bool => $p->scope === AdTargeting::SCOPE_COUNTRY;

        foreach ($candidates as $matches) {
            $match = $prices->first($matches);

            if ($match) {
                return $match;
            }
        }

        return null;
    }
}

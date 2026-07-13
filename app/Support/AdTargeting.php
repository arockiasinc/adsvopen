<?php

namespace App\Support;

use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Get;

/**
 * Where an advertiser wants their ad shown.
 *
 * The picker deliberately mirrors the province -> nearest-location choice a
 * customer makes when registering on the marketplace, so advertisers target the
 * exact same places customers are found in. On top of that it adds the wider
 * scopes an advertiser needs: the whole country, several provinces at once, or
 * one province end to end.
 *
 * Whatever the scope, targeting is stored the same way: a scope string plus
 * lists of province / region / city IDs.
 */
class AdTargeting
{
    /** Every province in the country. */
    public const SCOPE_COUNTRY = 'country';

    /** Several provinces, each end to end. */
    public const SCOPE_MULTI_PROVINCE = 'multi_province';

    /** One province, end to end. */
    public const SCOPE_PROVINCE = 'province';

    /** Named regions (counties / districts) inside one province. */
    public const SCOPE_REGION = 'region';

    /** Named cities inside one province — the marketplace's "nearest location". */
    public const SCOPE_CITY = 'city';

    /**
     * Scopes an advertiser can pick, in widening-to-narrowing order.
     *
     * @return array<string, string>
     */
    public static function scopeOptions(): array
    {
        return [
            self::SCOPE_COUNTRY => 'Country wide — every province',
            self::SCOPE_MULTI_PROVINCE => 'Multiple provinces',
            self::SCOPE_PROVINCE => 'Province wide — one province',
            self::SCOPE_REGION => 'Specific regions within a province',
            self::SCOPE_CITY => 'Specific cities within a province',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function scopeDescriptions(): array
    {
        return [
            self::SCOPE_COUNTRY => 'Your ad runs everywhere we operate.',
            self::SCOPE_MULTI_PROVINCE => 'Pick two or more provinces; the ad runs across all of each one.',
            self::SCOPE_PROVINCE => 'The ad runs across one whole province.',
            self::SCOPE_REGION => 'Pick the counties, districts or municipalities to cover.',
            self::SCOPE_CITY => 'Pick the nearest locations — the same city list customers choose from when they register.',
        ];
    }

    public static function scopeLabel(?string $scope): string
    {
        return self::scopeOptions()[$scope] ?? '—';
    }

    /**
     * Scopes the admin can attach a price to. "Multiple provinces" is absent on
     * purpose: it is priced as the sum of its provinces' province-wide rates.
     *
     * @return array<string, string>
     */
    public static function priceableScopeOptions(): array
    {
        return [
            self::SCOPE_COUNTRY => 'Country wide',
            self::SCOPE_PROVINCE => 'Province wide',
            self::SCOPE_REGION => 'Region',
            self::SCOPE_CITY => 'City',
        ];
    }

    public static function countryLabel(): string
    {
        return config('advertising.country_name', 'Canada').' (country-wide)';
    }

    /**
     * The location picker, shared by the advertiser wizard, the campaign form and
     * the admin. Field names match the columns on campaigns / advertising_inquiries.
     *
     * @return array<int, Forms\Components\Component>
     */
    public static function formSchema(): array
    {
        return [
            Forms\Components\Radio::make('target_scope')
                ->label('Where do you want to advertise?')
                ->options(self::scopeOptions())
                ->descriptions(self::scopeDescriptions())
                ->required()
                ->live()
                ->afterStateUpdated(function (Forms\Set $set): void {
                    // Selections from the previous scope no longer apply.
                    $set('target_province_id', null);
                    $set('target_province_ids', []);
                    $set('target_region_ids', []);
                    $set('target_city_ids', []);
                })
                ->columnSpanFull(),

            Forms\Components\Select::make('target_province_ids')
                ->label('Which provinces?')
                ->multiple()
                ->options(fn (): array => self::provinceOptions())
                ->searchable()
                ->live()
                ->minItems(2)
                ->required(fn (Get $get): bool => $get('target_scope') === self::SCOPE_MULTI_PROVINCE)
                ->visible(fn (Get $get): bool => $get('target_scope') === self::SCOPE_MULTI_PROVINCE)
                ->helperText('Select at least two provinces.')
                ->columnSpanFull(),

            Forms\Components\Select::make('target_province_id')
                ->label('Province')
                ->options(fn (): array => self::provinceOptions())
                ->searchable()
                ->required(fn (Get $get): bool => in_array(
                    $get('target_scope'),
                    [self::SCOPE_PROVINCE, self::SCOPE_REGION, self::SCOPE_CITY],
                    true,
                ))
                ->visible(fn (Get $get): bool => in_array(
                    $get('target_scope'),
                    [self::SCOPE_PROVINCE, self::SCOPE_REGION, self::SCOPE_CITY],
                    true,
                ))
                ->live()
                ->afterStateUpdated(function (Forms\Set $set): void {
                    $set('target_region_ids', []);
                    $set('target_city_ids', []);
                }),

            Forms\Components\Select::make('target_region_ids')
                ->label('Region(s)')
                ->multiple()
                ->options(fn (Get $get): array => self::regionOptions($get('target_province_id')))
                ->searchable()
                ->live()
                ->required(fn (Get $get): bool => $get('target_scope') === self::SCOPE_REGION)
                ->visible(fn (Get $get): bool => $get('target_scope') === self::SCOPE_REGION)
                ->helperText('Counties, districts and municipalities in the selected province.'),

            Forms\Components\Select::make('target_city_ids')
                ->label('Select nearest location(s)')
                ->multiple()
                ->options(fn (Get $get): array => self::cityOptions($get('target_province_id')))
                ->searchable()
                ->live()
                ->required(fn (Get $get): bool => $get('target_scope') === self::SCOPE_CITY)
                ->visible(fn (Get $get): bool => $get('target_scope') === self::SCOPE_CITY)
                ->helperText('The same city list customers pick from when they register.'),
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function provinceOptions(): array
    {
        return Province::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public static function regionOptions(int|string|null $provinceId): array
    {
        if (blank($provinceId)) {
            return [];
        }

        return Region::query()
            ->where('province_id', $provinceId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public static function cityOptions(int|string|null $provinceId): array
    {
        if (blank($provinceId)) {
            return [];
        }

        return City::query()
            ->where('province_id', $provinceId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    /**
     * Read the picker's current state straight out of a live form.
     *
     * @return array{target_scope: ?string, target_province_ids: array<int, int>, target_region_ids: array<int, int>, target_city_ids: array<int, int>}
     */
    public static function fromForm(Get $get): array
    {
        return self::normalise([
            'target_scope' => $get('target_scope'),
            'target_province_id' => $get('target_province_id'),
            'target_province_ids' => $get('target_province_ids'),
            'target_region_ids' => $get('target_region_ids'),
            'target_city_ids' => $get('target_city_ids'),
        ]);
    }

    /**
     * Collapse the form's scope-specific fields into the columns we store.
     *
     * @param  array<string, mixed>  $data
     * @return array{target_scope: ?string, target_province_ids: array<int, int>, target_region_ids: array<int, int>, target_city_ids: array<int, int>}
     */
    public static function normalise(array $data): array
    {
        $scope = $data['target_scope'] ?? null;
        $ids = fn (string $key): array => array_values(array_map(
            'intval',
            array_filter((array) ($data[$key] ?? []), fn ($id) => filled($id)),
        ));

        $provinceId = filled($data['target_province_id'] ?? null) ? (int) $data['target_province_id'] : null;

        $provinceIds = [];
        $regionIds = [];
        $cityIds = [];

        switch ($scope) {
            case self::SCOPE_COUNTRY:
                $provinceIds = Province::query()->where('is_active', true)->pluck('id')->all();
                break;

            case self::SCOPE_MULTI_PROVINCE:
                $provinceIds = $ids('target_province_ids');
                break;

            case self::SCOPE_PROVINCE:
                $provinceIds = $provinceId ? [$provinceId] : [];
                break;

            case self::SCOPE_REGION:
                $provinceIds = $provinceId ? [$provinceId] : [];
                $regionIds = $ids('target_region_ids');
                break;

            case self::SCOPE_CITY:
                $provinceIds = $provinceId ? [$provinceId] : [];
                $cityIds = $ids('target_city_ids');
                break;
        }

        return [
            'target_scope' => $scope,
            'target_province_ids' => array_map('intval', $provinceIds),
            'target_region_ids' => $regionIds,
            'target_city_ids' => $cityIds,
        ];
    }

    /**
     * Rebuild the scope-specific form fields from stored columns, so an existing
     * record can be edited.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function hydrate(array $data): array
    {
        $scope = $data['target_scope'] ?? null;
        $provinceIds = (array) ($data['target_province_ids'] ?? []);

        $data['target_province_id'] = in_array($scope, [self::SCOPE_PROVINCE, self::SCOPE_REGION, self::SCOPE_CITY], true)
            ? ($provinceIds[0] ?? null)
            : null;

        $data['target_province_ids'] = $scope === self::SCOPE_MULTI_PROVINCE ? $provinceIds : [];
        $data['target_region_ids'] = (array) ($data['target_region_ids'] ?? []);
        $data['target_city_ids'] = (array) ($data['target_city_ids'] ?? []);

        return $data;
    }

    /**
     * One-line-per-place summary of a target, for infolists and emails.
     *
     * @param  array<string, mixed>  $target
     * @return array<int, string>
     */
    public static function summarise(array $target): array
    {
        $scope = $target['target_scope'] ?? null;
        $provinceIds = (array) ($target['target_province_ids'] ?? []);
        $regionIds = (array) ($target['target_region_ids'] ?? []);
        $cityIds = (array) ($target['target_city_ids'] ?? []);

        $provinceNames = fn (): array => Province::query()->whereIn('id', $provinceIds)
            ->orderBy('name')->pluck('name')->all();

        return match ($scope) {
            self::SCOPE_COUNTRY => [self::countryLabel()],

            self::SCOPE_MULTI_PROVINCE => array_map(
                fn (string $name): string => $name.' (province-wide)',
                $provinceNames(),
            ),

            self::SCOPE_PROVINCE => array_map(
                fn (string $name): string => $name.' (province-wide)',
                $provinceNames(),
            ),

            self::SCOPE_REGION => Region::query()->with('province')->whereIn('id', $regionIds)
                ->orderBy('name')->get()
                ->map(fn (Region $region): string => $region->name.', '.$region->province?->name)
                ->all(),

            self::SCOPE_CITY => City::query()->with('province')->whereIn('id', $cityIds)
                ->orderBy('name')->get()
                ->map(fn (City $city): string => $city->name.', '.$city->province?->name)
                ->all(),

            default => [],
        };
    }
}

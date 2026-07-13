<?php

namespace Tests\Feature;

use App\Models\AdPrice;
use App\Models\AdType;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Services\AdPricingService;
use App\Support\AdTargeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdPricingTest extends TestCase
{
    use RefreshDatabase;

    protected AdType $adType;

    protected Province $ontario;

    protected Province $alberta;

    protected Region $simcoe;

    protected City $barrie;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adType = AdType::create(['name' => 'Banner Ads', 'slug' => 'banner-ads']);

        $this->ontario = Province::create(['id' => 671, 'name' => 'Ontario']);
        $this->alberta = Province::create(['id' => 663, 'name' => 'Alberta']);
        $this->simcoe = Region::create(['id' => 10, 'province_id' => $this->ontario->id, 'name' => 'Simcoe County']);
        $this->barrie = City::create([
            'id' => 100,
            'province_id' => $this->ontario->id,
            'region_id' => $this->simcoe->id,
            'name' => 'Barrie',
        ]);
    }

    protected function quote(array $target, ?int $days = null): array
    {
        return app(AdPricingService::class)->quote(
            $this->adType->id,
            AdTargeting::normalise($target),
            $days,
        );
    }

    public function test_country_wide_targeting_covers_every_province(): void
    {
        $target = AdTargeting::normalise(['target_scope' => AdTargeting::SCOPE_COUNTRY]);

        $this->assertEqualsCanonicalizing(
            [$this->ontario->id, $this->alberta->id],
            $target['target_province_ids'],
        );
    }

    public function test_a_city_uses_its_own_price_when_one_exists(): void
    {
        AdPrice::create(['ad_type_id' => $this->adType->id, 'scope' => AdTargeting::SCOPE_COUNTRY, 'price' => 8000, 'unit' => 'month']);
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_CITY,
            'province_id' => $this->ontario->id,
            'city_id' => $this->barrie->id,
            'price' => 500,
            'unit' => 'week',
        ]);

        $quote = $this->quote([
            'target_scope' => AdTargeting::SCOPE_CITY,
            'target_province_id' => $this->ontario->id,
            'target_city_ids' => [$this->barrie->id],
        ]);

        $this->assertSame(500.0, $quote['lines'][0]['price']);
        $this->assertSame(AdTargeting::SCOPE_CITY, $quote['lines'][0]['matched_scope']);
    }

    public function test_a_city_without_its_own_price_falls_back_to_region_then_province_then_country(): void
    {
        AdPrice::create(['ad_type_id' => $this->adType->id, 'scope' => AdTargeting::SCOPE_COUNTRY, 'price' => 8000, 'unit' => 'month']);

        $target = [
            'target_scope' => AdTargeting::SCOPE_CITY,
            'target_province_id' => $this->ontario->id,
            'target_city_ids' => [$this->barrie->id],
        ];

        // Only a country price exists.
        $this->assertSame(AdTargeting::SCOPE_COUNTRY, $this->quote($target)['lines'][0]['matched_scope']);

        // A province price beats the country one.
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_PROVINCE,
            'province_id' => $this->ontario->id,
            'price' => 3000,
            'unit' => 'month',
        ]);
        $this->assertSame(AdTargeting::SCOPE_PROVINCE, $this->quote($target)['lines'][0]['matched_scope']);

        // A region price beats the province one.
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_REGION,
            'province_id' => $this->ontario->id,
            'region_id' => $this->simcoe->id,
            'price' => 1200,
            'unit' => 'month',
        ]);
        $quote = $this->quote($target);
        $this->assertSame(AdTargeting::SCOPE_REGION, $quote['lines'][0]['matched_scope']);
        $this->assertSame(1200.0, $quote['lines'][0]['price']);
    }

    public function test_multi_province_prices_each_province_independently(): void
    {
        AdPrice::create(['ad_type_id' => $this->adType->id, 'scope' => AdTargeting::SCOPE_COUNTRY, 'price' => 8000, 'unit' => 'month']);
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_PROVINCE,
            'province_id' => $this->ontario->id,
            'price' => 3000,
            'unit' => 'month',
        ]);

        $quote = $this->quote([
            'target_scope' => AdTargeting::SCOPE_MULTI_PROVINCE,
            'target_province_ids' => [$this->ontario->id, $this->alberta->id],
        ]);

        // Ontario has its own rate; Alberta falls back to the country rate.
        $this->assertSame(11000.0, $quote['totals_by_unit']['month']);
        $this->assertCount(2, $quote['lines']);
    }

    public function test_an_unpriced_location_is_reported_rather_than_charged_zero(): void
    {
        $quote = $this->quote([
            'target_scope' => AdTargeting::SCOPE_PROVINCE,
            'target_province_id' => $this->alberta->id,
        ]);

        $this->assertSame([], $quote['lines']);
        $this->assertSame(['Alberta (province-wide)'], $quote['unpriced']);
        $this->assertNull($quote['estimated_total']);
    }

    public function test_a_campaign_is_priced_across_its_date_range(): void
    {
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_PROVINCE,
            'province_id' => $this->ontario->id,
            'price' => 100,
            'unit' => 'week',
        ]);

        $quote = $this->quote([
            'target_scope' => AdTargeting::SCOPE_PROVINCE,
            'target_province_id' => $this->ontario->id,
        ], days: 30);

        // 30 days needs 5 whole weeks.
        $this->assertSame(500.0, $quote['estimated_total']);
    }

    public function test_a_flat_rate_is_charged_once_however_long_the_campaign_runs(): void
    {
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_PROVINCE,
            'province_id' => $this->ontario->id,
            'price' => 2500,
            'unit' => AdPrice::UNIT_FLAT,
        ]);

        $target = [
            'target_scope' => AdTargeting::SCOPE_PROVINCE,
            'target_province_id' => $this->ontario->id,
        ];

        $this->assertSame(2500.0, $this->quote($target, days: 30)['estimated_total']);
        $this->assertSame(2500.0, $this->quote($target, days: 365)['estimated_total']);
    }

    public function test_inactive_prices_are_ignored(): void
    {
        AdPrice::create([
            'ad_type_id' => $this->adType->id,
            'scope' => AdTargeting::SCOPE_PROVINCE,
            'province_id' => $this->ontario->id,
            'price' => 3000,
            'unit' => 'month',
            'is_active' => false,
        ]);

        $quote = $this->quote([
            'target_scope' => AdTargeting::SCOPE_PROVINCE,
            'target_province_id' => $this->ontario->id,
        ]);

        $this->assertSame(['Ontario (province-wide)'], $quote['unpriced']);
    }
}

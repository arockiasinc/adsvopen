<?php

namespace Tests\Feature;

use App\Filament\Advertiser\Pages\StartAdvertising;
use App\Models\AdPrice;
use App\Models\AdType;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use App\Support\AdTargeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * The location picker and rate card have to actually render, and the public
 * questionnaire has to accept a targeted submission end to end.
 */
class AdvertisingScreensTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\AdTypeSeeder::class);

        $ontario = Province::create(['id' => 671, 'name' => 'Ontario']);
        $region = Region::create(['id' => 10, 'province_id' => $ontario->id, 'name' => 'Simcoe County']);
        City::create(['id' => 100, 'province_id' => $ontario->id, 'region_id' => $region->id, 'name' => 'Barrie']);
    }

    protected function admin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_approved' => true]);
    }

    protected function advertiser(): User
    {
        return User::factory()->create(['role' => 'advertiser', 'is_approved' => true]);
    }

    public function test_admin_can_open_the_rate_card_and_ad_types(): void
    {
        $admin = $this->admin();

        // The rate card must render with rows in it, not just when empty: the
        // price column formats money, and Filament's ->money() helper needs the
        // intl extension, which the deployed PHP does not have.
        $price = AdPrice::create([
            'ad_type_id' => AdType::where('slug', 'banner-ads')->firstOrFail()->id,
            'scope' => AdTargeting::SCOPE_CITY,
            'province_id' => 671,
            'city_id' => 100,
            'price' => 1234.50,
            'unit' => 'week',
            'currency' => 'CAD',
        ]);

        $this->actingAs($admin)->get('/admin/ad-prices')
            ->assertOk()
            ->assertSee('CAD $1,234.50')
            ->assertSee('Barrie, Ontario');

        $this->actingAs($admin)->get('/admin/ad-prices/create')->assertOk();
        $this->actingAs($admin)->get('/admin/ad-prices/'.$price->id.'/edit')->assertOk();
        $this->actingAs($admin)->get('/admin/ad-types')->assertOk();
    }

    public function test_advertiser_can_open_the_start_advertising_wizard(): void
    {
        $this->actingAs($this->advertiser())
            ->get('/advertiser/start-advertising')
            ->assertOk();
    }

    public function test_the_wizard_targets_a_city_and_saves_it(): void
    {
        $advertiser = $this->advertiser();
        $adType = AdType::where('slug', 'banner-ads')->firstOrFail();

        Livewire::actingAs($advertiser)
            ->test(StartAdvertising::class)
            // Every step past the first is gated on accepting the one-month minimum.
            ->set('data.accepts_terms', 'yes')
            ->assertSee('Where do you want to advertise?')
            ->set('data.business_name', 'Acme')
            ->set('data.industry', config('advertising.industries')[0])
            ->set('data.business_province', 'Ontario')
            ->set('data.company_size', 'small')
            ->set('data.ad_type_id', $adType->id)
            ->set('data.target_scope', AdTargeting::SCOPE_CITY)
            ->set('data.target_province_id', 671)
            ->set('data.target_city_ids', [100])
            ->set('data.sells_on_vopen', false)
            ->set('data.duration', '1-3')
            ->set('data.wants_website_link', false)
            ->set('data.ad_about', 'brand')
            ->set('data.display_schedule', '24hrs')
            ->set('data.daily_budget_band', '100-500')
            ->set('data.advertising_apps', false)
            ->set('data.special_promotion', false)
            ->set('data.generic_social_message', false)
            ->set('data.is_government_agency', false)
            ->set('data.contact_name', 'Ada')
            ->set('data.contact_email', 'ada@example.com')
            ->call('save')
            ->assertHasNoErrors();

        $inquiry = $advertiser->advertisingInquiries()->firstOrFail();

        $this->assertSame(AdTargeting::SCOPE_CITY, $inquiry->target_scope);
        $this->assertSame([671], $inquiry->target_province_ids);
        $this->assertSame([100], $inquiry->target_city_ids);
        $this->assertSame(['Barrie, Ontario'], $inquiry->targetSummary());
    }

    public function test_the_public_questionnaire_renders_the_new_location_picker(): void
    {
        $this->get('/start-advertising')
            ->assertOk()
            ->assertSee('Which type of advertisement?')
            ->assertSee('Country wide')
            ->assertSee('Multiple provinces')
            ->assertSee('Select nearest location(s)');
    }

    public function test_the_region_and_city_lookups_are_scoped_to_the_province(): void
    {
        $this->getJson('/advertising/regions?province_id=671')
            ->assertOk()
            ->assertJson([['id' => 10, 'name' => 'Simcoe County']]);

        $this->getJson('/advertising/cities?province_id=671')
            ->assertOk()
            ->assertJson([['id' => 100, 'name' => 'Barrie']]);

        // No province chosen yet -> nothing to offer.
        $this->getJson('/advertising/cities')->assertOk()->assertExactJson([]);
    }

    public function test_a_city_targeted_inquiry_is_saved_with_its_ids(): void
    {
        $advertiser = $this->advertiser();
        $adType = AdType::where('slug', 'banner-ads')->firstOrFail();

        $response = $this->actingAs($advertiser)->post('/start-advertising', [
            'accepts_terms' => 'yes',
            'business_name' => 'Acme',
            'industry' => config('advertising.industries')[0],
            'business_province' => 'Ontario',
            'company_size' => 'small',
            'ad_type_id' => $adType->id,
            'target_scope' => 'city',
            'target_province_id' => 671,
            'target_city_ids' => [100],
            'sells_on_vopen' => '0',
            'duration' => '1-3',
            'wants_website_link' => '0',
            'ad_about' => 'brand',
            'display_schedule' => '24hrs',
            'daily_budget_band' => '100-500',
            'advertising_apps' => '0',
            'special_promotion' => '0',
            'generic_social_message' => '0',
            'is_government_agency' => '0',
            'contact_name' => 'Ada',
            'contact_email' => 'ada@example.com',
        ]);

        $response->assertRedirect(route('start.advertising'));
        $response->assertSessionHasNoErrors();

        $inquiry = $advertiser->advertisingInquiries()->firstOrFail();

        $this->assertSame('city', $inquiry->target_scope);
        $this->assertSame([671], $inquiry->target_province_ids);
        $this->assertSame([100], $inquiry->target_city_ids);
        $this->assertSame($adType->id, $inquiry->ad_type_id);
        $this->assertSame(['Barrie, Ontario'], $inquiry->targetSummary());
    }

    public function test_a_city_outside_the_chosen_province_is_rejected(): void
    {
        Province::create(['id' => 663, 'name' => 'Alberta']);
        $adType = AdType::where('slug', 'banner-ads')->firstOrFail();

        $this->actingAs($this->advertiser())->post('/start-advertising', [
            'accepts_terms' => 'yes',
            'business_name' => 'Acme',
            'industry' => config('advertising.industries')[0],
            'business_province' => 'Ontario',
            'company_size' => 'small',
            'ad_type_id' => $adType->id,
            'target_scope' => 'city',
            'target_province_id' => 663, // Alberta...
            'target_city_ids' => [100],  // ...but Barrie is in Ontario.
            'sells_on_vopen' => '0',
            'duration' => '1-3',
            'wants_website_link' => '0',
            'ad_about' => 'brand',
            'display_schedule' => '24hrs',
            'daily_budget_band' => '100-500',
            'advertising_apps' => '0',
            'special_promotion' => '0',
            'generic_social_message' => '0',
            'is_government_agency' => '0',
            'contact_name' => 'Ada',
            'contact_email' => 'ada@example.com',
        ])->assertSessionHasErrors('target_city_ids');
    }
}

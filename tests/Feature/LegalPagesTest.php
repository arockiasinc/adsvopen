<?php

namespace Tests\Feature;

use App\Filament\Advertiser\Pages\Auth\Register;
use App\Models\LegalPage;
use App\Models\User;
use Database\Seeders\LegalPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LegalPageSeeder::class);
    }

    public function test_it_seeds_the_four_legal_pages(): void
    {
        $this->assertEqualsCanonicalizing(
            ['privacy-policy', 'cookies-policy', 'terms-of-use', 'terms-conditions'],
            LegalPage::query()->pluck('slug')->all(),
        );
    }

    public function test_a_published_legal_page_is_publicly_viewable(): void
    {
        $this->get(route('legal.page', 'privacy-policy'))
            ->assertOk()
            ->assertSee('Privacy Policy')
            ->assertSee('How does VOpen Ads collect information?', escape: false);
    }

    public function test_an_unpublished_or_unknown_legal_page_returns_404(): void
    {
        $this->get(route('legal.page', 'does-not-exist'))->assertNotFound();

        LegalPage::query()->where('slug', 'terms-of-use')->update(['status' => false]);

        $this->get(route('legal.page', 'terms-of-use'))->assertNotFound();
    }

    public function test_the_footer_links_every_published_footer_page(): void
    {
        $response = $this->get(route('home'))->assertOk();

        foreach (['privacy-policy', 'cookies-policy', 'terms-of-use', 'terms-conditions'] as $slug) {
            $response->assertSee(route('legal.page', $slug), escape: false);
        }
    }

    public function test_a_page_hidden_from_the_footer_is_not_linked_but_stays_reachable(): void
    {
        LegalPage::query()->where('slug', 'cookies-policy')->update(['is_footer' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee(route('legal.page', 'cookies-policy'), escape: false);

        $this->get(route('legal.page', 'cookies-policy'))->assertOk();
    }

    public function test_the_terms_modal_endpoint_returns_the_page_content(): void
    {
        $this->getJson(route('legal.content', 'terms-conditions'))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Terms & Conditions')
            ->assertJsonStructure(['success', 'data' => ['title', 'content']]);

        $this->getJson(route('legal.content', 'nope'))
            ->assertNotFound()
            ->assertJsonPath('success', false);
    }

    public function test_registration_is_blocked_when_the_terms_are_not_accepted(): void
    {
        Livewire::test(Register::class)
            ->fillForm($this->registrationData(termsAccepted: false))
            ->call('register')
            ->assertHasFormErrors(['terms_and_condition']);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_succeeds_and_records_consent_when_the_terms_are_accepted(): void
    {
        Livewire::test(Register::class)
            ->fillForm($this->registrationData(termsAccepted: true))
            ->call('register')
            ->assertHasNoFormErrors();

        $user = User::query()->where('email', 'advertiser@example.com')->firstOrFail();

        $this->assertNotNull($user->terms_accepted_at, 'The consent timestamp should be recorded.');
        $this->assertSame('advertiser', $user->role);
        $this->assertFalse($user->is_approved);
    }

    /**
     * @return array<string, mixed>
     */
    protected function registrationData(bool $termsAccepted): array
    {
        return [
            'name' => 'Ada Advertiser',
            'email' => 'advertiser@example.com',
            'password' => 'password123',
            'passwordConfirmation' => 'password123',
            'business_name' => 'Ada Co',
            'industry' => config('advertising.industries')[0],
            'business_province' => 'Manitoba',
            'company_size' => array_key_first(config('advertising.company_sizes')),
            'contact_name' => 'Ada',
            'contact_phone' => '204-555-0100',
            'terms_and_condition' => $termsAccepted,
        ];
    }
}

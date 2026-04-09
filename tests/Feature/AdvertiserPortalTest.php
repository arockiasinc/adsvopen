<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertiserPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_the_advertiser_workspace_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Advertiser Workspace')
            ->assertSee('Account Details')
            ->assertSee('Contact Info')
            ->assertSee('Business Details')
            ->assertSee('Available Advertisement Options')
            ->assertSee('My Ad Campaigns')
            ->assertSee('View My Ad')
            ->assertSee('Edit Ads')
            ->assertSee('Payment History')
            ->assertSee('Download Receipts');

        $this->actingAs($user)
            ->get(route('account.details'))
            ->assertOk()
            ->assertSee('Contact Info')
            ->assertSee('Business Details');

        $this->actingAs($user)
            ->get(route('advertisement.info'))
            ->assertOk()
            ->assertSee('Available Advertisement Options');

        $this->actingAs($user)
            ->get(route('campaigns.index'))
            ->assertOk()
            ->assertSee('View my ad')
            ->assertSee('Edit Ads');

        $this->actingAs($user)
            ->get(route('payments.index'))
            ->assertOk()
            ->assertSee('Download Receipt');
    }

    public function test_user_can_update_a_campaign_from_the_edit_ads_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('campaigns.update', 'starter-campaign'), [
            'title' => 'Updated Spring Campaign',
            'objective' => 'Lead generation',
            'format' => 'Banner Ads',
            'daily_budget' => 250,
            'headline' => 'Book more qualified homeowner leads',
            'copy' => 'Refresh your visibility with stronger messaging and more focused placements.',
            'cta' => 'Book Now',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(15)->toDateString(),
            'placements' => ['Banner Ads', 'Contractor Listing Ads'],
        ]);

        $response
            ->assertRedirect(route('campaigns.show', 'starter-campaign'))
            ->assertSessionHas('status', 'campaign-updated');

        $this->actingAs($user)
            ->get(route('campaigns.show', 'starter-campaign'))
            ->assertOk()
            ->assertSee('Updated Spring Campaign')
            ->assertSee('Book more qualified homeowner leads')
            ->assertSee('Book Now');
    }

    public function test_user_can_download_a_receipt(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('payments.receipts.download', 'rcpt-2026-001'))
            ->assertOk()
            ->assertHeader('content-type', 'text/plain; charset=UTF-8')
            ->assertHeader('content-disposition', 'attachment; filename="INV-2026-001.txt"')
            ->assertSee('Receipt: INV-2026-001');
    }
}

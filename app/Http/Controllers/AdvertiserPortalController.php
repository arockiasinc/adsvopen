<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdvertiserPortalController extends Controller
{
    public function dashboard(Request $request): View
    {
        $campaigns = $this->campaignsFor($request);
        $receipts = $this->receiptsFor($request);
        $advertisementOptions = $this->advertisementOptions();

        return view('dashboard', [
            'menuCount' => $this->menuCount(),
            'accountSummary' => $this->accountSummary($request),
            'campaigns' => $campaigns,
            'receipts' => $receipts,
            'advertisementOptions' => $advertisementOptions,
            'activeCampaignCount' => collect($campaigns)->where('status', 'Live')->count(),
        ]);
    }

    public function accountDetails(Request $request): View
    {
        return view('advertiser.account-details', [
            'accountSummary' => $this->accountSummary($request),
            'contactInfo' => $this->contactInfo($request),
            'businessDetails' => $this->businessDetails($request),
        ]);
    }

    public function advertisementInfo(Request $request): View
    {
        return view('advertiser.advertisement-info', [
            'accountSummary' => $this->accountSummary($request),
            'advertisementOptions' => $this->advertisementOptions(),
        ]);
    }

    public function campaigns(Request $request): View
    {
        $campaigns = $this->campaignsFor($request);

        return view('advertiser.campaigns.index', [
            'campaigns' => $campaigns,
            'draftCampaignCount' => collect($campaigns)->where('status', 'Draft')->count(),
            'liveCampaignCount' => collect($campaigns)->where('status', 'Live')->count(),
            'campaignBudgetTotal' => collect($campaigns)->sum('daily_budget'),
        ]);
    }

    public function showCampaign(Request $request, string $campaign): View
    {
        return view('advertiser.campaigns.show', [
            'campaign' => $this->findCampaign($request, $campaign),
        ]);
    }

    public function editCampaign(Request $request, string $campaign): View
    {
        return view('advertiser.campaigns.edit', [
            'campaign' => $this->findCampaign($request, $campaign),
            'availablePlacements' => collect($this->advertisementOptions())
                ->pluck('title')
                ->all(),
        ]);
    }

    public function updateCampaign(Request $request, string $campaign): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'objective' => ['required', 'string', 'max:120'],
            'format' => ['required', 'string', 'max:120'],
            'daily_budget' => ['required', 'integer', 'min:25', 'max:100000'],
            'headline' => ['required', 'string', 'max:120'],
            'copy' => ['required', 'string', 'max:500'],
            'cta' => ['required', 'string', 'max:40'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'placements' => ['required', 'array', 'min:1'],
            'placements.*' => ['string', 'max:120'],
        ]);

        $campaigns = collect($this->campaignsFor($request))
            ->map(function (array $currentCampaign) use ($campaign, $validated) {
                if ($currentCampaign['id'] !== $campaign) {
                    return $currentCampaign;
                }

                return array_merge($currentCampaign, $validated);
            })
            ->all();

        abort_unless(collect($campaigns)->contains(fn (array $currentCampaign) => $currentCampaign['id'] === $campaign), 404);

        $request->session()->put($this->campaignSessionKey($request), $campaigns);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('status', 'campaign-updated');
    }

    public function payments(Request $request): View
    {
        $receipts = $this->receiptsFor($request);

        return view('advertiser.payments.index', [
            'receipts' => $receipts,
            'receiptCount' => count($receipts),
            'paidTotal' => collect($receipts)->sum('amount'),
            'lastPaymentDate' => collect($receipts)->max('issued_on'),
        ]);
    }

    public function downloadReceipt(Request $request, string $receipt): Response
    {
        $receiptDetails = collect($this->receiptsFor($request))
            ->firstWhere('id', $receipt);

        abort_unless($receiptDetails, 404);

        $user = $request->user();

        $content = implode(PHP_EOL, [
            'Receipt: '.$receiptDetails['invoice_number'],
            'Account Holder: '.$user->name,
            'Email: '.$user->email,
            'Campaign: '.$receiptDetails['campaign_title'],
            'Amount Paid: $'.number_format($receiptDetails['amount'], 2),
            'Issued On: '.Carbon::parse($receiptDetails['issued_on'])->format('F j, Y'),
            'Status: '.$receiptDetails['status'],
        ]);

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$receiptDetails['invoice_number'].'.txt"',
        ]);
    }

    private function accountSummary(Request $request): array
    {
        $user = $request->user();

        return [
            'name' => $user->name,
            'username' => $user->username ?: 'Not set',
            'email' => $user->email,
            'role' => Str::headline($user->role),
            'member_since' => $user->created_at?->format('M d, Y') ?? 'Recently created',
            'business_label' => $this->businessLabel($request),
        ];
    }

    private function contactInfo(Request $request): array
    {
        $user = $request->user();

        return [
            ['label' => 'Primary email', 'value' => $user->email],
            ['label' => 'Username', 'value' => $user->username ?: 'Add a username from your profile'],
            ['label' => 'Account role', 'value' => Str::headline($user->role)],
            ['label' => 'Support channel', 'value' => 'Profile settings and dashboard support'],
        ];
    }

    private function businessDetails(Request $request): array
    {
        return [
            ['label' => 'Business name', 'value' => $this->businessLabel($request)],
            ['label' => 'Business type', 'value' => 'Advertising account'],
            ['label' => 'Primary market', 'value' => 'Update your campaign targeting during ad setup'],
            ['label' => 'Billing contact', 'value' => $request->user()->email],
        ];
    }

    private function advertisementOptions(): array
    {
        return [
            [
                'title' => 'Banner Ads',
                'placement' => 'High-visibility banner placements across the website',
                'best_for' => 'Awareness and broad reach',
                'starting_price' => '$250 / week',
                'description' => 'Use branded creatives to keep your business visible on high-traffic pages.',
            ],
            [
                'title' => 'Home Page Display Ads',
                'placement' => 'Premium featured placement on the home page',
                'best_for' => 'Flagship promotions and launches',
                'starting_price' => '$500 / week',
                'description' => 'Lead with a hero-style placement that captures attention as soon as visitors arrive.',
            ],
            [
                'title' => 'Product Sponsored Ads',
                'placement' => 'Promotional placements beside relevant product content',
                'best_for' => 'Intent-driven conversion campaigns',
                'starting_price' => '$350 / week',
                'description' => 'Reach visitors while they are actively comparing products and offers.',
            ],
            [
                'title' => 'Contractor Listing Ads',
                'placement' => 'Featured spots inside contractor and directory listings',
                'best_for' => 'Lead generation and local discovery',
                'starting_price' => '$200 / week',
                'description' => 'Stand out inside listings where buyers are already searching for service providers.',
            ],
            [
                'title' => 'Contractor Display Ads',
                'placement' => 'Display campaigns around contractor-focused content',
                'best_for' => 'Regional brand visibility',
                'starting_price' => '$300 / week',
                'description' => 'Stay in front of visitors researching contractors, pricing, and related services.',
            ],
        ];
    }

    private function campaignsFor(Request $request): array
    {
        return $request->session()->get(
            $this->campaignSessionKey($request),
            $this->defaultCampaigns($request)
        );
    }

    private function findCampaign(Request $request, string $campaign): array
    {
        $campaignDetails = collect($this->campaignsFor($request))
            ->firstWhere('id', $campaign);

        abort_unless($campaignDetails, 404);

        return $campaignDetails;
    }

    private function defaultCampaigns(Request $request): array
    {
        $businessLabel = $this->businessLabel($request);
        $startingDate = now()->addDays(4);

        return [
            [
                'id' => 'starter-campaign',
                'title' => $businessLabel.' Launch Campaign',
                'status' => 'Draft',
                'format' => 'Home Page Display Ads',
                'objective' => 'Brand awareness',
                'daily_budget' => 180,
                'headline' => 'Reach homeowners ready to book trusted services',
                'copy' => 'Introduce your business with a polished homepage placement and a clear call to action.',
                'cta' => 'Request Pricing',
                'start_date' => $startingDate->toDateString(),
                'end_date' => $startingDate->copy()->addDays(30)->toDateString(),
                'placements' => ['Home Page Display Ads', 'Banner Ads'],
                'metrics' => [
                    'Estimated reach' => '12,400 weekly views',
                    'Expected clicks' => '180 - 240',
                    'Primary audience' => 'Homeowners researching providers',
                ],
            ],
            [
                'id' => 'listing-boost',
                'title' => $businessLabel.' Listing Boost',
                'status' => 'Live',
                'format' => 'Contractor Listing Ads',
                'objective' => 'Lead generation',
                'daily_budget' => 95,
                'headline' => 'Show up first when customers compare local contractors',
                'copy' => 'Capture decision-ready traffic with featured listing exposure in relevant directories.',
                'cta' => 'Get a Quote',
                'start_date' => now()->subDays(12)->toDateString(),
                'end_date' => now()->addDays(18)->toDateString(),
                'placements' => ['Contractor Listing Ads', 'Contractor Display Ads'],
                'metrics' => [
                    'Estimated reach' => '7,800 weekly views',
                    'Expected clicks' => '95 - 130',
                    'Primary audience' => 'Local buyers with active intent',
                ],
            ],
        ];
    }

    private function receiptsFor(Request $request): array
    {
        $campaigns = $this->campaignsFor($request);

        return [
            [
                'id' => 'rcpt-2026-001',
                'invoice_number' => 'INV-2026-001',
                'campaign_title' => Arr::get($campaigns, '0.title', 'Launch Campaign'),
                'amount' => 1800,
                'issued_on' => now()->subDays(18)->toDateString(),
                'status' => 'Paid',
            ],
            [
                'id' => 'rcpt-2026-002',
                'invoice_number' => 'INV-2026-002',
                'campaign_title' => Arr::get($campaigns, '1.title', 'Listing Boost'),
                'amount' => 950,
                'issued_on' => now()->subDays(4)->toDateString(),
                'status' => 'Paid',
            ],
        ];
    }

    private function businessLabel(Request $request): string
    {
        $user = $request->user();

        if ($user->username) {
            return Str::headline($user->username);
        }

        return Str::headline($user->name);
    }

    private function campaignSessionKey(Request $request): string
    {
        return 'advertiser.campaigns.'.($request->user()?->getKey() ?? 'guest');
    }

    private function menuCount(): int
    {
        return Schema::hasTable('menus')
            ? Menu::query()->count()
            : 0;
    }
}

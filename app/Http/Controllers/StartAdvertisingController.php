<?php

namespace App\Http\Controllers;

use App\Models\AdvertisingInquiry;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class StartAdvertisingController extends Controller
{
    /**
     * Public marketing menus, mirroring routes/web.php behaviour.
     */
    protected function menus()
    {
        try {
            $menus = Schema::hasTable('menus')
                ? Menu::query()->ordered()->get()
                : collect([
                    (object) ['label' => 'Banner Ads', 'target' => route('banner.ads')],
                    (object) ['label' => 'Start Advertising', 'target' => route('start.advertising')],
                ]);
        } catch (Throwable $exception) {
            Log::warning('Falling back to default start advertising menus.', [
                'exception' => $exception->getMessage(),
            ]);

            $menus = collect([
                (object) ['label' => 'Banner Ads', 'target' => route('banner.ads')],
                (object) ['label' => 'Start Advertising', 'target' => route('start.advertising')],
            ]);
        }

        return $menus->map(function ($menu) {
            if (trim(strtolower((string) $menu->label)) === 'banner ads') {
                $menu->target = route('banner.ads');
            }

            return $menu;
        });
    }

    public function show(): View
    {
        $user = auth()->user();
        $profile = $user?->advertiserProfile;

        return view('start-advertising', [
            'menus' => $this->menus(),
            'pageTitle' => 'Start Advertising',
            'pageDescription' => "Answer a few quick questions to get custom recommendations for your business's advertising needs on VOpen Market.",
            'prefill' => [
                'business_name' => old('business_name', $user?->name),
                'contact_name' => old('contact_name', $profile?->contact_name ?? $user?->name),
                'contact_email' => old('contact_email', $profile?->contact_email ?? $user?->email),
                'contact_phone' => old('contact_phone', $profile?->contact_phone),
            ],
            'recommendations' => session('advertising_recommendations'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (! auth()->check()) {
            session()->put('url.intended', route('start.advertising'));

            return redirect()
                ->route('filament.advertiser.auth.login')
                ->with('advertising_login_required', 'Please log in to your advertiser account to submit your advertising request.');
        }

        $sizes = array_keys(config('advertising.company_sizes'));
        $durations = array_keys(config('advertising.durations'));
        $adAbout = array_keys(config('advertising.ad_about'));
        $schedules = array_keys(config('advertising.display_schedules'));
        $bands = array_keys(config('advertising.daily_budget_bands'));
        $provinces = config('advertising.provinces');
        $targetable = array_merge([config('advertising.country_wide_label')], $provinces);

        $validated = $request->validate([
            'accepts_terms' => ['required', 'in:yes,no'],
            'business_name' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'in:'.implode(',', config('advertising.industries'))],
            'business_province' => ['required', 'string', 'in:'.implode(',', $provinces)],
            'company_size' => ['required', 'in:'.implode(',', $sizes)],
            'target_provinces' => ['required', 'array', 'min:1'],
            'target_provinces.*' => ['in:'.implode(',', $targetable)],
            'target_regions' => ['nullable', 'array'],
            'target_regions.*' => ['array'],
            'target_regions.*.*' => ['array'],
            'target_regions.*.*.*' => ['string', 'max:255'],
            'sells_on_vopen' => ['required', 'in:0,1'],
            'seller_id' => ['nullable', 'required_if:sells_on_vopen,1', 'string', 'max:255'],
            'duration' => ['required', 'in:'.implode(',', $durations)],
            'wants_website_link' => ['required', 'in:0,1'],
            'website_link' => ['nullable', 'required_if:wants_website_link,1', 'url', 'max:255'],
            'ad_about' => ['required', 'in:'.implode(',', $adAbout)],
            'ad_about_other' => ['nullable', 'required_if:ad_about,others', 'string', 'max:255'],
            'display_schedule' => ['required', 'in:'.implode(',', $schedules)],
            'daily_budget_band' => ['required', 'in:'.implode(',', $bands)],
            'daily_budget_other' => ['nullable', 'required_if:daily_budget_band,other', 'integer', 'min:0'],
            'yearly_marketing_budget' => ['nullable', 'integer', 'min:0'],
            'advertising_apps' => ['required', 'in:0,1'],
            'special_promotion' => ['required', 'in:0,1'],
            'generic_social_message' => ['required', 'in:0,1'],
            'is_government_agency' => ['required', 'in:0,1'],
            'digital_file' => ['nullable', 'file', 'max:20480', 'mimes:jpg,jpeg,png,gif,webp,svg,mp4,mov,pdf'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['accepts_terms'] !== 'yes') {
            return back()
                ->withInput()
                ->with('advertising_declined', config('advertising.min_commitment_notice'));
        }

        $filePath = null;
        if ($request->hasFile('digital_file')) {
            $filePath = $request->file('digital_file')->store('advertising-inquiries', 'public');
        }

        $recommendations = $this->buildRecommendations($validated);
        $targetRegions = $this->prepareTargetRegions(
            $validated['target_regions'] ?? [],
            $validated['target_provinces'],
        );

        AdvertisingInquiry::create([
            'user_id' => auth()->id(),
            'accepts_terms' => true,
            'business_name' => $validated['business_name'],
            'industry' => $validated['industry'],
            'business_province' => $validated['business_province'],
            'company_size' => $validated['company_size'],
            'target_provinces' => $validated['target_provinces'],
            'target_regions' => $targetRegions,
            'sells_on_vopen' => (bool) $validated['sells_on_vopen'],
            'seller_id' => $validated['seller_id'] ?? null,
            'duration' => $validated['duration'],
            'wants_website_link' => (bool) $validated['wants_website_link'],
            'website_link' => $validated['website_link'] ?? null,
            'ad_about' => $validated['ad_about'],
            'ad_about_other' => $validated['ad_about_other'] ?? null,
            'display_schedule' => $validated['display_schedule'],
            'daily_budget_band' => $validated['daily_budget_band'],
            'daily_budget_other' => $validated['daily_budget_other'] ?? null,
            'advertising_apps' => (bool) $validated['advertising_apps'],
            'special_promotion' => (bool) $validated['special_promotion'],
            'generic_social_message' => (bool) $validated['generic_social_message'],
            'yearly_marketing_budget' => $validated['yearly_marketing_budget'] ?? null,
            'is_government_agency' => (bool) $validated['is_government_agency'],
            'digital_file_path' => $filePath,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'] ?? null,
            'recommendations' => $recommendations,
            'status' => 'New',
        ]);

        return redirect()
            ->route('start.advertising')
            ->with('advertising_recommendations', $recommendations)
            ->with('advertising_submitted', true);
    }

    /**
     * @return array<int, string>
     */
    protected function buildRecommendations(array $data): array
    {
        $recommendations = config('advertising.recommendations_by_size')[$data['company_size']] ?? [];

        $lowBudget = config('advertising.recommendation_low_budget');
        if (($data['daily_budget_band'] ?? null) === $lowBudget['band']) {
            $recommendations = array_merge($recommendations, $lowBudget['options']);
        }

        return array_values(array_unique($recommendations));
    }

    /**
     * Remove UI-only checkbox markers and keep region choices aligned to the
     * selected provinces before saving the inquiry.
     */
    protected function prepareTargetRegions(array $regions, array $targetProvinces): array
    {
        $selectedProvinces = array_flip($targetProvinces);
        $categories = config('advertising.region_categories');
        $provinceCategories = config('advertising.province_region_categories', []);
        $clean = [];

        foreach ($regions as $province => $provinceRegions) {
            if (! isset($selectedProvinces[$province]) || ! is_array($provinceRegions)) {
                continue;
            }

            $availableCategories = array_replace_recursive($categories, $provinceCategories[$province] ?? []);

            foreach ($provinceRegions as $category => $places) {
                if (! isset($availableCategories[$category]) || ! is_array($places)) {
                    continue;
                }

                $selectedPlaces = array_values(array_filter(
                    array_unique($places),
                    fn ($place) => $place !== '__category',
                ));

                if (empty($selectedPlaces) && in_array('__category', $places, true)) {
                    $label = $availableCategories[$category]['label'];
                    $selectedPlaces = ["All {$label}"];
                }

                if (! empty($selectedPlaces)) {
                    $clean[$province][$category] = $selectedPlaces;
                }
            }
        }

        return $clean;
    }
}

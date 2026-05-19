<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\StartAdvertisingController;
use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Public marketing site
|--------------------------------------------------------------------------
| All authenticated/admin functionality now lives in the Filament panel
| at /admin (see app/Providers/Filament/AdminPanelProvider.php). These
| routes only serve the public-facing pages.
*/

$resolveMenus = function () {
    try {
        $menus = Schema::hasTable('menus')
            ? Menu::query()->ordered()->get()
            : collect([
                (object) ['label' => 'Banner Ads', 'target' => '#placements'],
                (object) ['label' => 'Home page display Ads', 'target' => '#importance'],
                (object) ['label' => 'Product Sponsored ads', 'target' => '#case-studies'],
                (object) ['label' => 'Contractor Listing Ads', 'target' => '#partner-support'],
                (object) ['label' => 'Contractor Display ads', 'target' => '#creative-support'],
                (object) ['label' => 'Start Advertising', 'target' => '#campaign-setup'],
            ]);
    } catch (Throwable $exception) {
        Log::warning('Falling back to default public menus.', [
            'exception' => $exception->getMessage(),
        ]);

        $menus = collect([
            (object) ['label' => 'Banner Ads', 'target' => '#placements'],
            (object) ['label' => 'Home page display Ads', 'target' => '#importance'],
            (object) ['label' => 'Product Sponsored ads', 'target' => '#case-studies'],
            (object) ['label' => 'Contractor Listing Ads', 'target' => '#partner-support'],
            (object) ['label' => 'Contractor Display ads', 'target' => '#creative-support'],
            (object) ['label' => 'Start Advertising', 'target' => '#campaign-setup'],
        ]);
    }

    return $menus->map(function ($menu) {
        if (trim(strtolower((string) $menu->label)) === 'banner ads') {
            $menu->target = route('banner.ads');
        }

        return $menu;
    });
};

$resolveHeroSlides = function () {
    $defaultSlides = collect([
        [
            'image_url' => asset('images/case-study-photo-1.jpg'),
            'title' => 'Where you advertise matters.',
            'copy' => 'Be found where and when you need to be.',
            'detail' => 'We have it all covered, tailored to fit your goals.',
            'highlights' => [
                'Display Advertising',
                'Product Advertising',
                'Priority Listings',
                'Sponsored Ads',
            ],
            'buttonRows' => [],
            'footer' => 'Canada\'s only platform to reach the right audience.',
        ],
        [
            'image_url' => asset('images/case-study-photo-2.jpg'),
            'title' => 'Turn limited-time offers into bold visual stories that drive action.',
            'copy' => 'Use campaign-specific artwork and messaging to support holiday promotions, awareness pushes, or time-sensitive banner placements.',
            'detail' => null,
            'highlights' => [],
            'buttonRows' => [],
            'footer' => null,
        ],
        [
            'image_url' => asset('images/hero-scene.svg'),
            'title' => 'Advertisement options available for all types of businesses and budgets',
            'copy' => null,
            'detail' => null,
            'highlights' => [],
            'buttonRows' => [
                ['Banner Ads', 'Contractor Listing Ads', 'Contractors Display Ads'],
                ['Native Ads', 'Shoppable Ads', 'GIF Ads'],
                ['Listing Ads', 'Product Ads', 'Search Page Display Ads'],
            ],
            'footer' => 'When it comes to advertising, there\'s only one place to be: right here.',
        ],
    ]);

    try {
        if (! Schema::hasTable('banners')) {
            return $defaultSlides;
        }

        return Banner::query()
            ->ordered()
            ->get()
            ->map(function (Banner $banner) {
                return [
                    'image_url' => $banner->image_url,
                    'title' => $banner->title,
                    'copy' => $banner->copy,
                    'detail' => $banner->detail,
                    'highlights' => $banner->highlights ?? [],
                    'buttonRows' => $banner->button_rows ?? [],
                    'footer' => $banner->footer,
                ];
            });
    } catch (Throwable $exception) {
        Log::warning('Falling back to default public hero slides.', [
            'exception' => $exception->getMessage(),
        ]);

        return $defaultSlides;
    }
};

Route::get('/', function () use ($resolveHeroSlides, $resolveMenus) {
    return view('home', [
        'heroSlides' => $resolveHeroSlides(),
        'menus' => $resolveMenus(),
        'pageTitle' => 'Home',
        'pageDescription' => 'Homepage for Canada\'s Only VOpen Market advertising solutions.',
    ]);
})->name('home');

Route::get('/banners/{banner}/image', [BannerController::class, 'image'])->name('banners.image');

Route::get('/banner-ads', function () use ($resolveMenus) {
    return view('banner-ads', [
        'menus' => $resolveMenus(),
        'pageTitle' => 'Banner Ads',
        'pageDescription' => 'Banner Ads information page for Canada\'s Only VOpen Market.',
    ]);
})->name('banner.ads');

// Public "Start Advertising" questionnaire. The page is public; submitting
// requires a logged-in advertiser (guests are sent to the advertiser login).
Route::get('/start-advertising', [StartAdvertisingController::class, 'show'])->name('start.advertising');
Route::post('/start-advertising', [StartAdvertisingController::class, 'store'])
    ->name('start.advertising.store');

// Kept outside the /advertiser Filament panel path to avoid route collisions.
Route::get('/receipts/{payment}', [ReceiptController::class, 'show'])->name('advertiser.receipt');

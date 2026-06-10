<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdvertiserLoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\StartAdvertisingController;
use App\Models\Banner;
use App\Models\Menu;
use Filament\Http\Middleware\SetUpPanel;
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
    $defaultMenuItems = [
        (object) ['label' => 'Home', 'target' => ''],
        (object) ['label' => 'Panoramic Banner Ads', 'target' => 'panoramic-banner-ads'],
        (object) ['label' => 'Leaderboard Ads', 'target' => 'leaderboard-ads'],
        (object) ['label' => 'Product Sponsored ads', 'target' => 'product-sponsored-ads'],
        (object) ['label' => 'Product Carousel', 'target' => 'product-carousel'],
        (object) ['label' => 'Start Advertising', 'target' => 'start-advertising'],
        (object) ['label' => 'Contact', 'target' => 'contact'],
    ];

    try {
        $menus = Schema::hasTable('menus')
            ? Menu::query()->ordered()->get()
            : collect($defaultMenuItems);
    } catch (Throwable $exception) {
        Log::warning('Falling back to default public menus.', [
            'exception' => $exception->getMessage(),
        ]);

        $menus = collect($defaultMenuItems);
    }

    // Resolve each menu item's href. Named pages map to their route; anything
    // else is treated as an in-page anchor on the home page so links stay valid
    // even when the app is served from a sub-path (e.g. XAMPP /adsvopen/).
    $routedLabels = [
        'home' => route('home'),
        'panoramic banner ads' => route('banner.ads'),
        'leaderboard ads' => route('leaderboard.ads'),
        'start advertising' => route('start.advertising'),
    ];

    return $menus->map(function ($menu) use ($routedLabels) {
        $label = trim(strtolower((string) $menu->label));

        if (isset($routedLabels[$label])) {
            $menu->target = $routedLabels[$label];
        } else {
            $anchor = ltrim((string) $menu->target, '#');
            $menu->target = route('home').'#'.$anchor;
        }

        return $menu;
    });
};

$resolveHeroSlides = function () {
    $normalizeTextList = function ($items): array {
        if (! is_array($items)) {
            return [];
        }

        return collect($items)
            ->map(function ($item): ?string {
                if (is_string($item) || is_numeric($item)) {
                    return trim((string) $item);
                }

                if (! is_array($item)) {
                    return null;
                }

                foreach (['label', 'name', 'value', 'title'] as $key) {
                    if (isset($item[$key]) && (is_string($item[$key]) || is_numeric($item[$key]))) {
                        return trim((string) $item[$key]);
                    }
                }

                return null;
            })
            ->filter(fn (?string $item): bool => filled($item))
            ->values()
            ->all();
    };

    $normalizeButtonRows = function ($rows) use ($normalizeTextList): array {
        if (! is_array($rows)) {
            return [];
        }

        return collect($rows)
            ->map(function ($row) use ($normalizeTextList): array {
                if (is_array($row) && array_key_exists('buttons', $row)) {
                    return $normalizeTextList((array) $row['buttons']);
                }

                return $normalizeTextList(is_array($row) ? $row : [$row]);
            })
            ->filter(fn (array $row): bool => $row !== [])
            ->values()
            ->all();
    };

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
            ->map(function (Banner $banner) use ($normalizeTextList, $normalizeButtonRows) {
                return [
                    'image_url' => $banner->image_url,
                    'title' => $banner->title,
                    'copy' => $banner->copy,
                    'detail' => $banner->detail,
                    'highlights' => $normalizeTextList($banner->highlights ?? []),
                    'buttonRows' => $normalizeButtonRows($banner->button_rows ?? []),
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
        'pageTitle' => 'Panoramic Ads',
        'pageDescription' => 'Panoramic Ads information page for Canada\'s Only VOpen Market.',
    ]);
})->name('banner.ads');

Route::get('/leaderboard-ads', function () use ($resolveMenus) {
    return view('leaderboard-ads', [
        'menus' => $resolveMenus(),
        'pageTitle' => 'Leaderboard Ads',
        'pageDescription' => 'Homepage Leaderboard Ad placements serving local ads across Canada with VOpen Market.',
    ]);
})->name('leaderboard.ads');

// Public "Start Advertising" questionnaire. The page is public; submitting
// requires a logged-in advertiser (guests are sent to the advertiser login).
Route::get('/start-advertising', [StartAdvertisingController::class, 'show'])->name('start.advertising');
Route::post('/start-advertising', [StartAdvertisingController::class, 'store'])
    ->name('start.advertising.store');

Route::post('/advertiser/login', AdvertiserLoginController::class)
    ->middleware(SetUpPanel::class.':advertiser')
    ->name('advertiser.login.store');

Route::post('/admin/login', AdminLoginController::class)
    ->middleware(SetUpPanel::class.':admin')
    ->name('admin.login.store');

// Kept outside the /advertiser Filament panel path to avoid route collisions.
Route::get('/receipts/{payment}', [ReceiptController::class, 'show'])->name('advertiser.receipt');

<?php

use App\Http\Controllers\AdvertiserPortalController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

$resolveMenus = function () {
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

    return $menus->map(function ($menu) {
        if (trim(strtolower((string) $menu->label)) === 'banner ads') {
            $menu->target = route('banner.ads');
        }

        return $menu;
    });
};

$resolveHeroSlides = function () {
    if (! Schema::hasTable('banners')) {
        return collect([
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdvertiserPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/account-details', [AdvertiserPortalController::class, 'accountDetails'])->name('account.details');
    Route::get('/advertisement-info', [AdvertiserPortalController::class, 'advertisementInfo'])->name('advertisement.info');
    Route::get('/my-ad-campaigns', [AdvertiserPortalController::class, 'campaigns'])->name('campaigns.index');
    Route::get('/my-ad-campaigns/{campaign}', [AdvertiserPortalController::class, 'showCampaign'])->name('campaigns.show');
    Route::get('/my-ad-campaigns/{campaign}/edit', [AdvertiserPortalController::class, 'editCampaign'])->name('campaigns.edit');
    Route::patch('/my-ad-campaigns/{campaign}', [AdvertiserPortalController::class, 'updateCampaign'])->name('campaigns.update');
    Route::get('/payment-history', [AdvertiserPortalController::class, 'payments'])->name('payments.index');
    Route::get('/payment-history/receipts/{receipt}', [AdvertiserPortalController::class, 'downloadReceipt'])->name('payments.receipts.download');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::patch('/menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::patch('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::patch('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
});

require __DIR__.'/auth.php';

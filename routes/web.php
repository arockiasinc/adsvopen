<?php

use App\Http\Controllers\AdvertiserPortalController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
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

    return view('home', [
        'menus' => $menus,
    ]);
})->name('home');

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
});

require __DIR__.'/auth.php';

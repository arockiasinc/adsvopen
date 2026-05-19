<?php

namespace App\Providers;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // After logging out of the Filament admin panel, send the user back
        // to the public site so the frontend header reflects the logged-out
        // state instead of returning to /admin/login.
        $this->app->bind(LogoutResponseContract::class, function () {
            return new class implements LogoutResponseContract
            {
                public function toResponse($request): RedirectResponse
                {
                    return redirect()->to('/');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // When the app is served from a subfolder (e.g. https://winnipage.ca/adsvopen),
        // Livewire's update/script routes must be prefixed with that path. This MUST
        // be configured at boot time — Livewire registers these routes during its
        // own service-provider boot, so doing it from per-request middleware is too
        // late and leaves Livewire/Filament pages unable to resolve the update route.
        $configuredBasePath = rtrim((string) parse_url((string) config('app.url'), PHP_URL_PATH), '/');
        $requestBasePath = rtrim(str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
        $basePath = $configuredBasePath !== '' && $configuredBasePath !== '/'
            ? $configuredBasePath
            : ($requestBasePath === '/' || $requestBasePath === '.' ? '' : $requestBasePath);

        if ($basePath !== '') {
            $script = config('app.debug') ? 'livewire.js' : 'livewire.min.js';

            config(['livewire.asset_url' => "{$basePath}/livewire/{$script}"]);

            Livewire::setScriptRoute(
                fn ($handle) => Route::get("{$basePath}/livewire/{$script}", $handle)
            );

            Livewire::setUpdateRoute(
                fn ($handle) => Route::post("{$basePath}/livewire/update", $handle)->middleware('web')
            );
        }
    }
}

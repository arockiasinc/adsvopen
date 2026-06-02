<?php

namespace App\Providers;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
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
        $rawConfiguredBasePath = (string) parse_url((string) config('app.url'), PHP_URL_PATH);
        $rawRequestBasePath = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '')));

        $configuredBasePath = $this->normalizePublicUrlBasePath($rawConfiguredBasePath);
        $requestBasePath = $this->normalizePublicUrlBasePath($rawRequestBasePath);
        $basePath = $configuredBasePath !== '' && $configuredBasePath !== '/'
            ? $configuredBasePath
            : ($requestBasePath === '/' || $requestBasePath === '.' ? '' : $requestBasePath);

        if (
            $this->normalizePublicUrlBasePath($rawConfiguredBasePath) !== rtrim($rawConfiguredBasePath, '/')
            || $this->normalizePublicUrlBasePath($rawRequestBasePath) !== rtrim($rawRequestBasePath, '/')
        ) {
            $assetOrigin = $this->publicAssetOrigin($basePath);

            if ($assetOrigin !== null) {
                config(['app.asset_url' => $assetOrigin]);
                URL::useAssetOrigin($assetOrigin);
            }
        }

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

    private function normalizePublicUrlBasePath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));

        if ($path === '' || $path === '.' || $path === '/') {
            return '';
        }

        $segments = array_values(array_filter(explode('/', $path), fn (string $segment): bool => $segment !== '' && $segment !== '.'));

        if (end($segments) === 'index.php') {
            array_pop($segments);
        }

        if (end($segments) === 'public') {
            array_pop($segments);
        }

        return $segments === [] ? '' : '/'.implode('/', $segments);
    }

    private function publicAssetOrigin(string $basePath): ?string
    {
        $configuredUrl = (string) config('app.url');
        $configuredHost = parse_url($configuredUrl, PHP_URL_HOST);

        if (is_string($configuredHost) && $configuredHost !== '' && ! in_array($configuredHost, ['localhost', '127.0.0.1'], true)) {
            $scheme = parse_url($configuredUrl, PHP_URL_SCHEME) ?: 'https';
            $port = parse_url($configuredUrl, PHP_URL_PORT);

            return $scheme.'://'.$configuredHost.($port ? ":{$port}" : '').$basePath;
        }

        if (app()->runningInConsole()) {
            return null;
        }

        return request()->getSchemeAndHttpHost().$basePath;
    }
}

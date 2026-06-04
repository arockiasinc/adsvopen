<?php

namespace App\Providers;

use App\Http\Controllers\BannerController;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Features\SupportFileUploads\FilePreviewController;
use Livewire\Features\SupportFileUploads\FileUploadController;
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
        // When the public URL is HTTPS, force every generated URL/asset to use
        // the https scheme. Shared hosts often terminate SSL at a proxy, so the
        // PHP request can look like http and asset() would emit http:// scripts
        // — which the browser then blocks as mixed content on the https page.
        // Guarding on app.url keeps http://localhost working in local dev.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        $this->forceRuntimeRequestRoot();

        // When the app is served from a subfolder (e.g. https://winnipage.ca/adsvopen),
        // Livewire's update/script routes must be prefixed with that path. This MUST
        // be configured at boot time — Livewire registers these routes during its
        // own service-provider boot, so doing it from per-request middleware is too
        // late and leaves Livewire/Filament pages unable to resolve the update route.
        $rawConfiguredBasePath = (string) parse_url((string) config('app.url'), PHP_URL_PATH);
        $rawRequestBasePath = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '')));

        $basePath = $this->resolvePublicBasePath($rawConfiguredBasePath, $rawRequestBasePath);

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

            // Livewire's file-upload URLs are signed against the original named
            // routes. Add subfolder-aware aliases so those signed URLs resolve
            // when the shared host doesn't strip the app base path.
            Route::post("{$basePath}/livewire/upload-file", [FileUploadController::class, 'handle']);
            Route::get("{$basePath}/livewire/preview-file/{filename}", [FilePreviewController::class, 'handle']);
            Route::get("{$basePath}/banners/{banner}/image", [BannerController::class, 'image']);
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

    private function resolvePublicBasePath(string $configuredPath, string $requestPath): string
    {
        $configuredBasePath = $this->normalizePublicUrlBasePath($configuredPath);
        $requestBasePath = $this->normalizePublicUrlBasePath($requestPath);

        return $configuredBasePath !== ''
            ? $configuredBasePath
            : ($requestBasePath === '/' || $requestBasePath === '.' ? '' : $requestBasePath);
    }

    private function forceRuntimeRequestRoot(): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $request = request();
        $host = $request->getHost();

        if ($host === '' || in_array($host, ['localhost', '127.0.0.1'], true)) {
            return;
        }

        $scheme = $this->publicRequestScheme();
        $basePath = $this->resolvePublicBasePath(
            (string) parse_url((string) config('app.url'), PHP_URL_PATH),
            $request->getBasePath(),
        );

        URL::forceRootUrl($scheme.'://'.$request->getHttpHost().$basePath);

        if ($scheme === 'https') {
            URL::forceScheme('https');
        }
    }

    private function publicRequestScheme(): string
    {
        $request = request();
        $forwardedProto = strtolower((string) $request->headers->get('X-Forwarded-Proto'));

        if (str_contains($forwardedProto, 'https')) {
            return 'https';
        }

        $forwardedSsl = strtolower((string) $request->headers->get('X-Forwarded-Ssl'));

        if ($forwardedSsl === 'on') {
            return 'https';
        }

        if (str_contains(strtolower((string) $request->headers->get('CF-Visitor')), '"scheme":"https"')) {
            return 'https';
        }

        $https = strtolower((string) $request->server('HTTPS'));

        if ($https !== '' && $https !== 'off') {
            return 'https';
        }

        if ((string) $request->server('SERVER_PORT') === '443' || $request->isSecure()) {
            return 'https';
        }

        $configuredScheme = parse_url((string) config('app.url'), PHP_URL_SCHEME);

        return in_array($configuredScheme, ['http', 'https'], true)
            ? $configuredScheme
            : $request->getScheme();
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

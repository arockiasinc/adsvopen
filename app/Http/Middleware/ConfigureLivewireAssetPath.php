<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\Response;

class ConfigureLivewireAssetPath
{
    public function handle(Request $request, Closure $next): Response
    {
        $baseUrl = rtrim($request->getBaseUrl(), '/');

        if ($baseUrl !== '') {
            $script = config('app.debug') ? 'livewire.js' : 'livewire.min.js';

            config([
                'livewire.asset_url' => "{$baseUrl}/livewire/{$script}",
            ]);

            Livewire::setScriptRoute(fn ($handle) => Route::get("{$baseUrl}/livewire/{$script}", $handle));

            Livewire::setUpdateRoute(
                fn ($handle) => Route::post("{$baseUrl}/livewire/update", $handle)->middleware('web')
            );
        }

        return $next($request);
    }
}

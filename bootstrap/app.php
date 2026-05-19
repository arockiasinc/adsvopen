<?php

use App\Http\Middleware\ConfigureLivewireAssetPath;
use App\Http\Middleware\TemporaryBasicAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(prepend: [
            ConfigureLivewireAssetPath::class,
            TemporaryBasicAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Shared-hosting layout: when public/ has been merged into the project root
// (index.php sits next to app/, vendor/, etc.), use the project root as the
// public path so asset(), public_path(), and Vite resolve correctly.
if (! is_dir(dirname(__DIR__).'/public') && is_file(dirname(__DIR__).'/index.php')) {
    $app->usePublicPath(dirname(__DIR__));
}

return $app;

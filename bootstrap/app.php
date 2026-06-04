<?php

use App\Http\Middleware\TemporaryBasicAuth;
use App\Http\Middleware\LogLivewireUploadFailures;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$temporaryDirectory = __DIR__.'/../storage/framework/tmp';

if (! is_dir($temporaryDirectory)) {
    @mkdir($temporaryDirectory, 0775, true);
}

if (is_dir($temporaryDirectory) && is_writable($temporaryDirectory)) {
    $temporaryDirectory = realpath($temporaryDirectory) ?: $temporaryDirectory;

    foreach (['TMPDIR', 'TMP', 'TEMP'] as $environmentVariable) {
        putenv("{$environmentVariable}={$temporaryDirectory}");
        $_ENV[$environmentVariable] = $temporaryDirectory;
        $_SERVER[$environmentVariable] = $temporaryDirectory;
    }
}

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(prepend: [
            TemporaryBasicAuth::class,
            LogLivewireUploadFailures::class,
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

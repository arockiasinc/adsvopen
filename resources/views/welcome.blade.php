<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @include('partials.vite-or-cdn')
    </head>
    <body class="bg-gradient-primary">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5 text-center">
                            <div class="text-uppercase text-primary font-weight-bold small mb-3">Vopen Market</div>
                            <h1 class="h2 text-gray-900 font-weight-bold mb-3">{{ config('app.name', 'Laravel') }}</h1>
                            <p class="text-muted mb-4">This project now uses an SB Admin 2 powered backend instead of the old starter dashboard scaffold.</p>

                            <div class="d-flex justify-content-center flex-wrap">
                                <a href="{{ route('home') }}" class="btn btn-primary mr-2 mb-2">View Website</a>

                                @auth
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mb-2">Open Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary mb-2">Log In</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

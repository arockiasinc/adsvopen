<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel').' Auth')</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

        @include('partials.vite-or-cdn')
    </head>
    <body class="@yield('body_class', '')">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-xl-10 col-lg-12 col-md-10">
                    <div class="card o-hidden border-0 shadow-lg auth-shell my-5">
                        <div class="card-body p-0">
                            <div class="row no-gutters">
                                <div class="col-lg-6 d-none d-lg-flex auth-panel">
                                    <div class="auth-panel__inner">
                                        <span class="badge badge-light text-primary px-3 py-2 text-uppercase font-weight-bold">Vopen Market</span>
                                        <h1 class="h2 text-white font-weight-bold mt-4 mb-3">A cleaner backend experience for your project.</h1>
                                        <p class="text-white-50 mb-0">
                                            Sign in to manage menus, review dashboard activity, and keep your admin area organized with the new Bootstrap layout.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center mb-4">
                                            <a href="{{ route('home') }}" class="text-decoration-none">
                                                <div class="small text-uppercase text-primary font-weight-bold mb-2">{{ config('app.name', 'Laravel') }}</div>
                                            </a>
                                            <h1 class="h4 text-gray-900 mb-2">@yield('auth_title', 'Welcome Back')</h1>
                                            <p class="mb-0 text-muted">@yield('auth_subtitle')</p>
                                        </div>

                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>

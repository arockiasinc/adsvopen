<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel').' Admin')</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body id="page-top">
        <div id="wrapper">
            @include('layouts.navigation')

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" type="button">
                            <i class="fa fa-bars"></i>
                        </button>

                        <div class="d-flex align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@yield('page_eyebrow', 'Admin')</div>
                                <div class="text-sm text-gray-800 font-weight-bold">@yield('page_heading', 'Dashboard')</div>
                            </div>
                        </div>

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                    <span class="admin-avatar rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('account.details') }}">
                                        <i class="fas fa-id-card fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Account Details
                                    </a>
                                    <a class="dropdown-item" href="{{ route('campaigns.index') }}">
                                        <i class="fas fa-layer-group fa-sm fa-fw mr-2 text-gray-400"></i>
                                        My Ad Campaigns
                                    </a>
                                    <a class="dropdown-item" href="{{ route('payments.index') }}">
                                        <i class="fas fa-file-invoice-dollar fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Payment History
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    @if (auth()->user()->isAdmin())
                                        <a class="dropdown-item" href="{{ route('banners.index') }}">
                                            <i class="fas fa-images fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Banners
                                        </a>
                                        <a class="dropdown-item" href="{{ route('menus.index') }}">
                                            <i class="fas fa-bars fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Menus
                                        </a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <div class="container-fluid">
                        @yield('page_header')
                        @yield('content')
                    </div>
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>&copy; {{ config('app.name', 'Laravel') }} {{ now()->year }}</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        @stack('modals')
        @stack('scripts')
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  @php
    $stylePath = public_path('css/style.css');
    $styleVersion = file_exists($stylePath) ? filemtime($stylePath) : null;
  @endphp
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle ?? 'Banner Ads' }}</title>
  <meta name="description" content="{{ $pageDescription ?? 'Banner Ads landing page template with a clean editorial layout inspired by the supplied reference design.' }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}{{ $styleVersion ? '?v='.$styleVersion : '' }}">
</head>
<body class="font-sans text-copy antialiased heading-spaced">
  <header class="site-header">
    <div class="site-header-inner" data-mobile-menu data-mobile-menu-open="false">
      <a class="site-brand" href="{{ route('home') }}" aria-label="Home">
        <img class="site-brand-image" src="{{ asset('images/logo.webp') }}" alt="Site logo">
      </a>

      <button
        class="site-menu-toggle"
        type="button"
        aria-expanded="false"
        aria-controls="site-header-panel"
        data-mobile-menu-toggle
      >
        <span class="site-menu-toggle-box" aria-hidden="true">
          <span class="site-menu-toggle-line"></span>
          <span class="site-menu-toggle-line"></span>
          <span class="site-menu-toggle-line"></span>
        </span>
        <span class="site-menu-toggle-label">Menu</span>
      </button>

      <div class="site-header-panel" id="site-header-panel" data-mobile-menu-panel>
        <nav class="site-header-nav" aria-label="Primary">
          @foreach ($menus as $menu)
            <a class="site-header-link" href="{{ $menu->target }}">{{ $menu->label }}</a>
          @endforeach
        </nav>

        <div class="site-header-actions">
          <button class="site-search-button" type="button" aria-label="Search">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="11" cy="11" r="5.5" fill="none" stroke="currentColor" stroke-width="2.5"></circle>
              <path d="M15.5 15.5L21 21" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2.5"></path>
            </svg>
          </button>
          @auth
            @php
              $isAdminUser = auth()->user()->isAdmin();
              $panelRoute = $isAdminUser
                ? 'filament.admin.pages.dashboard'
                : 'filament.advertiser.pages.dashboard';
              $logoutRouteName = $isAdminUser
                ? 'filament.admin.auth.logout'
                : 'filament.advertiser.auth.logout';
              $panelHome = Route::has($panelRoute) ? route($panelRoute) : route('home');
              $logoutRoute = Route::has($logoutRouteName) ? route($logoutRouteName) : null;
            @endphp
            <a class="site-auth-link" href="{{ $panelHome }}">{{ auth()->user()->name }}</a>

            @if ($logoutRoute)
              <form action="{{ $logoutRoute }}" class="site-auth-form" method="POST">
                @csrf
                <button class="site-logout-button" type="submit">Logout</button>
              </form>
            @endif
          @else
            @if (Route::has('filament.advertiser.auth.login'))
              <a class="site-auth-link" href="{{ route('filament.advertiser.auth.login') }}">Login</a>
            @endif
            @if (Route::has('filament.advertiser.auth.register'))
              <a class="site-register-link" href="{{ route('filament.advertiser.auth.register') }}">Register</a>
            @endif
          @endauth
        </div>
      </div>
    </div>
  </header>

  <main id="top">

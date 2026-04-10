@php
    $accountActive = request()->routeIs('account.*');
    $advertisementActive = request()->routeIs('advertisement.*') || request()->routeIs('campaigns.*');
    $campaignActive = request()->routeIs('campaigns.*');
    $viewAdPageActive = request()->routeIs('campaigns.show');
    $viewAdActive = request()->routeIs('campaigns.show') || request()->routeIs('campaigns.edit');
    $editAdActive = request()->routeIs('campaigns.edit');
    $paymentActive = request()->routeIs('payments.*');
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <img class="sidebar-brand-logo" src="{{ asset('images/v1-logo.png') }}" alt="{{ config('app.name', 'Laravel') }} logo">
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ $accountActive ? 'active' : '' }}">
        <a
            class="nav-link {{ $accountActive ? '' : 'collapsed' }}"
            href="#"
            data-toggle="collapse"
            data-target="#collapseAccountDetails"
            aria-expanded="{{ $accountActive ? 'true' : 'false' }}"
            aria-controls="collapseAccountDetails"
        >
            <i class="fas fa-fw fa-id-card"></i>
            <span>Account Details</span>
        </a>
        <div
            id="collapseAccountDetails"
            class="collapse {{ $accountActive ? 'show' : '' }}"
            aria-labelledby="headingAccountDetails"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ $accountActive ? 'active' : '' }}" href="{{ route('account.details') }}#contact-info">
                    Contact Info
                </a>
                <a class="collapse-item {{ $accountActive ? 'active' : '' }}" href="{{ route('account.details') }}#business-details">
                    Business Details
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ $advertisementActive ? 'active' : '' }}">
        <a
            class="nav-link {{ $advertisementActive ? '' : 'collapsed' }}"
            href="#"
            data-toggle="collapse"
            data-target="#collapseAdvertisementInfo"
            aria-expanded="{{ $advertisementActive ? 'true' : 'false' }}"
            aria-controls="collapseAdvertisementInfo"
        >
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Advertisement Info</span>
        </a>
        <div
            id="collapseAdvertisementInfo"
            class="collapse {{ $advertisementActive ? 'show' : '' }}"
            aria-labelledby="headingAdvertisementInfo"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded">
             
                <a class="collapse-item {{ request()->routeIs('advertisement.info') ? 'active' : '' }}" href="{{ route('advertisement.info') }}#available-advertisement-options">
                    Available Advertisement <br/> Options
                </a>
                <a
                    class="collapse-item collapse-item--toggle {{ $campaignActive ? 'active' : 'collapsed' }}"
                    href="#collapseCampaignLinks"
                    data-toggle="collapse"
                    aria-expanded="{{ $campaignActive ? 'true' : 'false' }}"
                    aria-controls="collapseCampaignLinks"
                >
                    <span>My Ad Campaigns</span>
                    <i class="fas fa-angle-right collapse-item__arrow"></i>
                </a>
                <div id="collapseCampaignLinks" class="collapse {{ $campaignActive ? 'show' : '' }}">
                    <div class="collapse-inner collapse-inner--nested py-1">
                        <div class="collapse-item collapse-item--flush collapse-item--nested collapse-item--branch collapse-item--no-prefix {{ $viewAdActive ? 'active' : '' }}">
                            <a class="collapse-item__label {{ $viewAdPageActive ? 'active' : '' }}" href="{{ route('campaigns.show', 'starter-campaign') }}#view-my-ad">
                                View My Ad
                            </a>
                            <a
                                class="collapse-item__trigger {{ $viewAdActive ? '' : 'collapsed' }}"
                                href="#collapseViewAdLinks"
                                data-toggle="collapse"
                                aria-expanded="{{ $viewAdActive ? 'true' : 'false' }}"
                                aria-controls="collapseViewAdLinks"
                            >
                                <i class="fas fa-angle-right collapse-item__arrow"></i>
                            </a>
                        </div>
                        <div id="collapseViewAdLinks" class="collapse {{ $viewAdActive ? 'show' : '' }}">
                            <div class="collapse-inner collapse-inner--nested py-1">
                                <a class="collapse-item collapse-item--flush collapse-item--deep collapse-item--no-prefix {{ $editAdActive ? 'active' : '' }}" href="{{ route('campaigns.edit', 'starter-campaign') }}#edit-ads">
                                  Edit Ads
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="nav-item {{ $paymentActive ? 'active' : '' }}">
        <a
            class="nav-link {{ $paymentActive ? '' : 'collapsed' }}"
            href="#"
            data-toggle="collapse"
            data-target="#collapsePaymentHistory"
            aria-expanded="{{ $paymentActive ? 'true' : 'false' }}"
            aria-controls="collapsePaymentHistory"
        >
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Payment History</span>
        </a>
        <div
            id="collapsePaymentHistory"
            class="collapse {{ $paymentActive ? 'show' : '' }}"
            aria-labelledby="headingPaymentHistory"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ $paymentActive ? 'active' : '' }}" href="{{ route('payments.index') }}#download-receipts">
                    Download Receipts
                </a>
            </div>
        </div>
    </li>

    @if (auth()->user()->isAdmin())
        <li class="nav-item {{ request()->routeIs('banners.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('banners.index') }}">
                <i class="fas fa-fw fa-images"></i>
                <span>Banners</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('menus.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('menus.index') }}">
                <i class="fas fa-fw fa-bars"></i>
                <span>Menus</span>
            </a>
        </li>
    @endif

    <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Profile</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-card d-none d-lg-flex">
        <div class="sidebar-card-illustration mb-2">
            <i class="fas fa-bullseye fa-2x text-white-50"></i>
        </div>
        <p class="text-center mb-2 text-white-50 small">Manage account details, ad campaigns, and receipts from one advertiser workspace.</p>
        <a class="btn btn-light btn-sm" href="{{ route('campaigns.index') }}">Open Campaigns</a>
    </div>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" type="button"></button>
    </div>
</ul>

@extends('layouts.app')

@section('title', 'Dashboard - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'Dashboard')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-muted">Keep your account details, advertisement options, campaigns, and payment history in one place.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('campaigns.index') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm mr-2">
                <i class="fas fa-layer-group fa-sm text-white-50 mr-1"></i>
                My Ad Campaigns
            </a>
            <a href="{{ route('advertisement.info') }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm">
                <i class="fas fa-bullhorn fa-sm mr-1"></i>
                Available Advertisement Options
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Account Details</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $accountSummary['email'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-id-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Advertisement Options</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ count($advertisementOptions) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Live Campaigns</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $activeCampaignCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rocket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Download Receipts</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ count($receipts) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-download fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="portal-hero rounded p-4 p-lg-5">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="text-xs font-weight-bold text-uppercase text-white-50 mb-2">Advertiser Portal</div>
                                <h2 class="h3 mb-3 text-white font-weight-bold">Everything you asked for now has a dedicated home in the dashboard.</h2>
                                <p class="mb-4 text-white-50">
                                    Review your account details, compare advertisement placements, manage your ad campaigns, and download receipts without leaving the workspace.
                                </p>
                                <div class="d-flex flex-wrap">
                                    <a href="{{ route('account.details') }}" class="btn btn-light btn-icon-split mr-3 mb-2">
                                        <span class="icon text-primary">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <span class="text">Account Details</span>
                                    </a>
                                    <a href="{{ route('payments.index') }}" class="btn btn-outline-light mb-2">Payment History</a>
                                </div>
                            </div>
                            <div class="col-lg-4 d-none d-lg-block text-center">
                                <i class="fas fa-bullseye fa-7x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Account Details</h6>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 detail-stack">
                                <dt class="col-sm-5">Contact Info</dt>
                                <dd class="col-sm-7">{{ $accountSummary['email'] }}</dd>
                                <dt class="col-sm-5">Business Details</dt>
                                <dd class="col-sm-7">{{ $accountSummary['business_label'] }}</dd>
                                <dt class="col-sm-5">Username</dt>
                                <dd class="col-sm-7">{{ $accountSummary['username'] }}</dd>
                            </dl>
                            <a href="{{ route('account.details') }}" class="btn btn-link px-0 mt-3">Open account details</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Advertisement Info</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Available advertisement options are ready for quick comparison.</p>
                            <ul class="list-unstyled mb-3">
                                @foreach (collect($advertisementOptions)->take(3) as $option)
                                    <li class="mb-2">
                                        <div class="font-weight-bold text-gray-800">{{ $option['title'] }}</div>
                                        <div class="small text-muted">{{ $option['starting_price'] }}</div>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('advertisement.info') }}" class="btn btn-link px-0">View all ad options</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Ad Campaigns</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach ($campaigns as $campaign)
                            <a href="{{ route('campaigns.show', $campaign['id']) }}" class="list-group-item list-group-item-action px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="font-weight-bold text-gray-800">{{ $campaign['title'] }}</div>
                                    <span class="badge badge-{{ $campaign['status'] === 'Live' ? 'success' : 'warning' }}">{{ $campaign['status'] }}</span>
                                </div>
                                <div class="small text-muted">{{ $campaign['format'] }}</div>
                                <div class="small text-primary mt-2">View my ad</div>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('campaigns.index') }}" class="btn btn-primary btn-block mt-3">Edit Ads</a>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment History</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Download receipts for your recent advertising activity.</p>
                    <div class="list-group list-group-flush">
                        @foreach ($receipts as $receipt)
                            <a href="{{ route('payments.receipts.download', $receipt['id']) }}" class="list-group-item list-group-item-action px-0">
                                <div class="font-weight-bold text-gray-800">{{ $receipt['invoice_number'] }}</div>
                                <div class="small text-muted">{{ $receipt['campaign_title'] }}</div>
                                <div class="small text-primary mt-2">Download Receipt</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @if (auth()->user()->isAdmin())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Tools</h6>
                    </div>
                    <div class="card-body">
                        <div class="font-weight-bold text-gray-800">Frontend menu items</div>
                        <div class="small text-muted mb-3">{{ $menuCount }} menu links currently available.</div>
                        <a href="{{ route('menus.index') }}" class="btn btn-outline-primary btn-sm">Manage Menus</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

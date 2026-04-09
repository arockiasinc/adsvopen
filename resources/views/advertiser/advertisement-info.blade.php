@extends('layouts.app')

@section('title', 'Advertisement Info - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'Advertisement Info')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Advertisement Info</h1>
            <p class="mb-0 text-muted">Compare the available advertisement options before launching or editing your ads.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('campaigns.index') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-layer-group fa-sm text-white-50 mr-1"></i>
                My Ad Campaigns
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="portal-banner rounded p-4 p-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="text-xs font-weight-bold text-uppercase text-white-50 mb-2">Available Advertisement Options</div>
                        <h2 class="h3 mb-3 text-white font-weight-bold">Choose placements that match your goals.</h2>
                        <p class="mb-0 text-white-50">
                            Your account for <strong class="text-white">{{ $accountSummary['business_label'] }}</strong> can be promoted through homepage, banner, sponsored, and contractor-focused placements.
                        </p>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-center">
                        <i class="fas fa-bullhorn fa-6x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="available-advertisement-options">
        @foreach ($advertisementOptions as $option)
            <div class="col-xl-6 mb-4">
                <div class="card shadow h-100 option-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="h5 mb-1 text-gray-800">{{ $option['title'] }}</h3>
                                <div class="small text-muted">{{ $option['placement'] }}</div>
                            </div>
                            <span class="badge badge-light option-price">{{ $option['starting_price'] }}</span>
                        </div>
                        <p class="text-muted">{{ $option['description'] }}</p>
                        <div class="small font-weight-bold text-primary text-uppercase mb-1">Best For</div>
                        <div class="text-gray-800">{{ $option['best_for'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

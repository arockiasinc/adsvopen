@extends('layouts.app')

@section('title', 'My Ad Campaigns - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'My Ad Campaigns')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">My Ad Campaigns</h1>
            <p class="mb-0 text-muted">View your ad campaigns, open each ad preview, and edit ad settings.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('advertisement.info') }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm mr-2">
                <i class="fas fa-bullhorn fa-sm mr-1"></i>
                Available Advertisement Options
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if (session('status') === 'campaign-updated')
        <div class="alert alert-success">Your ad campaign was updated successfully.</div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Live Campaigns</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $liveCampaignCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Draft Campaigns</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $draftCampaignCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Combined Daily Budget</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">${{ number_format($campaignBudgetTotal) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4" id="my-ad-campaigns">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Campaign List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Status</th>
                            <th>Format</th>
                            <th>Daily Budget</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-gray-800">{{ $campaign['title'] }}</div>
                                    <div class="small text-muted">{{ $campaign['objective'] }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $campaign['status'] === 'Live' ? 'success' : 'warning' }}">{{ $campaign['status'] }}</span>
                                </td>
                                <td>{{ $campaign['format'] }}</td>
                                <td>${{ number_format($campaign['daily_budget']) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('campaigns.show', $campaign['id']) }}" class="btn btn-outline-primary btn-sm mr-2">View my ad</a>
                                    <a href="{{ route('campaigns.edit', $campaign['id']) }}" class="btn btn-primary btn-sm">Edit Ads</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'View My Ad - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'View My Ad')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">View My Ad</h1>
            <p class="mb-0 text-muted">Review the current campaign messaging, placements, and delivery details.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('campaigns.edit', $campaign['id']) }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-pen fa-sm text-white-50 mr-1"></i>
                Edit Ads
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if (session('status') === 'campaign-updated')
        <div class="alert alert-success">Your ad campaign was updated successfully.</div>
    @endif

    <div class="row">
        <div class="col-xl-8 mb-4" id="view-my-ad">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $campaign['title'] }}</h6>
                    <span class="badge badge-{{ $campaign['status'] === 'Live' ? 'success' : 'warning' }}">{{ $campaign['status'] }}</span>
                </div>
                <div class="card-body">
                    <div class="campaign-preview rounded p-4 mb-4">
                        <div class="small text-uppercase font-weight-bold text-primary mb-2">{{ $campaign['format'] }}</div>
                        <h2 class="h4 text-gray-900 font-weight-bold">{{ $campaign['headline'] }}</h2>
                        <p class="text-muted mb-4">{{ $campaign['copy'] }}</p>
                        <button type="button" class="btn btn-primary">{{ $campaign['cta'] }}</button>
                    </div>

                    <div class="row">
                        @foreach ($campaign['metrics'] as $label => $value)
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <div class="text-xs font-weight-bold text-uppercase text-primary mb-1">{{ $label }}</div>
                                    <div class="font-weight-bold text-gray-800">{{ $value }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Campaign Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 detail-stack">
                        <dt class="col-sm-5">Objective</dt>
                        <dd class="col-sm-7">{{ $campaign['objective'] }}</dd>
                        <dt class="col-sm-5">Daily Budget</dt>
                        <dd class="col-sm-7">${{ number_format($campaign['daily_budget']) }}</dd>
                        <dt class="col-sm-5">Start Date</dt>
                        <dd class="col-sm-7">{{ \Illuminate\Support\Carbon::parse($campaign['start_date'])->format('M d, Y') }}</dd>
                        <dt class="col-sm-5">End Date</dt>
                        <dd class="col-sm-7">{{ \Illuminate\Support\Carbon::parse($campaign['end_date'])->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Placements</h6>
                </div>
                <div class="card-body">
                    @foreach ($campaign['placements'] as $placement)
                        <div class="badge badge-light border text-dark p-2 mr-2 mb-2">{{ $placement }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

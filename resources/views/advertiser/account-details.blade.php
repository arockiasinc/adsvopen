@extends('layouts.app')

@section('title', 'Account Details - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'Account Details')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Account Details</h1>
            <p class="mb-0 text-muted">Review contact info and business details for your advertiser account.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('profile.edit') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-user-edit fa-sm text-white-50 mr-1"></i>
                Update Profile
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Account Holder</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $accountSummary['name'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Username</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $accountSummary['username'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Member Since</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $accountSummary['member_since'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 mb-4" id="contact-info">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact Info</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 detail-stack">
                        @foreach ($contactInfo as $item)
                            <dt class="col-sm-5">{{ $item['label'] }}</dt>
                            <dd class="col-sm-7">{{ $item['value'] }}</dd>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-4" id="business-details">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Business Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 detail-stack">
                        @foreach ($businessDetails as $item)
                            <dt class="col-sm-5">{{ $item['label'] }}</dt>
                            <dd class="col-sm-7">{{ $item['value'] }}</dd>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

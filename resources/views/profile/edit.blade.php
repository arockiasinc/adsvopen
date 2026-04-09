@extends('layouts.app')

@section('title', 'Profile - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Account Settings')
@section('page_heading', 'Profile')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Profile</h1>
            <p class="mb-0 text-muted">Update your account information, password, and security settings.</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card shadow mb-4 border-left-danger">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection

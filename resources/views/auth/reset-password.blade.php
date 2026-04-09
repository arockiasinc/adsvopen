@extends('layouts.guest')

@section('title', 'Reset Password - '.config('app.name', 'Laravel'))
@section('auth_title', 'Reset Password')
@section('auth_subtitle', 'Choose a new password for your account.')

@section('content')
    <form class="user" method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <input
                id="email"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                placeholder="Email Address"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback d-block text-left">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <input
                id="password"
                class="form-control form-control-user @error('password') is-invalid @enderror"
                type="password"
                name="password"
                placeholder="Password"
                required
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback d-block text-left">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <input
                id="password_confirmation"
                class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                required
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <div class="invalid-feedback d-block text-left">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Reset Password
        </button>
    </form>
@endsection

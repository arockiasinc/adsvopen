@extends('layouts.guest')

@section('title', 'Register - '.config('app.name', 'Laravel'))
@section('auth_title', 'Create an Account')
@section('auth_subtitle', 'Set up a new user account for the admin area.')

@section('content')
    <form class="user" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <input
                id="name"
                class="form-control form-control-user @error('name') is-invalid @enderror"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Full Name"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback d-block text-left">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <input
                id="email"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Email Address"
                required
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
            Register Account
        </button>
    </form>

    <hr>

    <div class="text-center">
        <a class="small" href="{{ route('login') }}">Already registered? Log in</a>
    </div>
@endsection

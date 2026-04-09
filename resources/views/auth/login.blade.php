@extends('layouts.guest')

@section('title', 'Log In - '.config('app.name', 'Laravel'))
@section('auth_title', 'Welcome Back')
@section('auth_subtitle', 'Sign in to access your admin dashboard.')

@section('content')
    @if (session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

    <form class="user" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <input
                id="login"
                class="form-control form-control-user @error('login') is-invalid @enderror"
                type="text"
                name="login"
                value="{{ old('login', old('email')) }}"
                placeholder="Username or Email"
                required
                autofocus
                autocomplete="username"
            >
            @error('login')
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
                autocomplete="current-password"
            >
            @error('password')
                <div class="invalid-feedback d-block text-left">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-left">
            <div class="custom-control custom-checkbox small">
                <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                <label class="custom-control-label" for="remember_me">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Log In
        </button>
    </form>

    <hr>

    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="small" href="{{ route('password.request') }}">Forgot your password?</a>
        @endif
    </div>
    <div class="text-center">
        <a class="small" href="{{ route('register') }}">Create an account</a>
    </div>
@endsection

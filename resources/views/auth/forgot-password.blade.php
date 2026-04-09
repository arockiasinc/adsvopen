@extends('layouts.guest')

@section('title', 'Forgot Password - '.config('app.name', 'Laravel'))
@section('auth_title', 'Forgot Your Password?')
@section('auth_subtitle', 'Enter your email address and we will send you a reset link.')

@section('content')
    @if (session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

    <form class="user" method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <input
                id="email"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Email Address"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback d-block text-left">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Email Password Reset Link
        </button>
    </form>

    <hr>

    <div class="text-center">
        <a class="small" href="{{ route('login') }}">Back to login</a>
    </div>
@endsection

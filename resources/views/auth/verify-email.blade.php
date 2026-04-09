@extends('layouts.guest')

@section('title', 'Verify Email - '.config('app.name', 'Laravel'))
@section('auth_title', 'Verify Your Email')
@section('auth_subtitle', 'Before getting started, please confirm your email address using the link we sent you.')

@section('content')
    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success small">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <p class="small text-muted mb-4">
        Thanks for signing up! If you didn't receive the email, we can send another verification link.
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Resend Verification Email
        </button>
    </form>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link btn-block">Log Out</button>
    </form>
@endsection

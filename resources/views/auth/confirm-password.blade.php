@extends('layouts.guest')

@section('title', 'Confirm Password - '.config('app.name', 'Laravel'))
@section('auth_title', 'Confirm Password')
@section('auth_subtitle', 'This is a secure area of the application. Please confirm your password before continuing.')

@section('content')
    <form class="user" method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Confirm
        </button>
    </form>
@endsection

<section>
    <div class="mb-4">
        <h2 class="h5 text-gray-900 font-weight-bold">Profile Information</h2>
        <p class="mb-0 text-muted">Update your account's profile information and email address.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">Profile saved successfully.</div>
    @endif

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded border bg-light px-3 py-3">
                    <div class="font-weight-bold text-gray-800 mb-2">Your email address is unverified.</div>
                    <button form="send-verification" class="btn btn-link p-0 align-baseline" type="submit">
                        Click here to re-send the verification email.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="small text-success mt-2">A new verification link has been sent to your email address.</div>
                    @endif
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</section>

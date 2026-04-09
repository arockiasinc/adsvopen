<section>
    <div class="mb-4">
        <h2 class="h5 text-gray-900 font-weight-bold">Update Password</h2>
        <p class="mb-0 text-muted">Ensure your account is using a long, random password to stay secure.</p>
    </div>

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">Password updated successfully.</div>
    @endif

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Current Password</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">New Password</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password"
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Confirm Password</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Password</button>
    </form>
</section>

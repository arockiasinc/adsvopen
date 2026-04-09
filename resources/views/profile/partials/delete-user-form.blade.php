<section>
    <div class="mb-4">
        <h2 class="h5 text-danger font-weight-bold">Delete Account</h2>
        <p class="mb-0 text-muted">
            Once your account is deleted, all of its resources and data will be permanently deleted. Please make sure you want to continue.
        </p>
    </div>

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
        Delete Account
    </button>
</section>

@push('modals')
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Are you sure you want to delete your account?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Enter your password to confirm.
                        </p>

                        <div class="form-group mb-0">
                            <label for="delete_account_password">Password</label>
                            <input
                                id="delete_account_password"
                                name="password"
                                type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="Password"
                            >
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    @if ($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                $('#deleteAccountModal').modal('show');
            });
        </script>
    @endif
@endpush

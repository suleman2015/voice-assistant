<section class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <header class="mb-4">
                <h2 class="h5 text-dark">
                    {{ __('Update Password') }}
                </h2>
                <p class="text-muted small">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                        <input id="update_password_current_password" name="current_password" type="password"
                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                            autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                        <input id="update_password_password" name="password" type="password"
                            class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                            autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                            autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save Changes') }}
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success small" id="passwordSavedMessage">{{ __('Saved.') }}</span>

                        <script>
                            setTimeout(() => {
                                const msg = document.getElementById('passwordSavedMessage');
                                if (msg) msg.style.display = 'none';
                            }, 2000);
                        </script>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

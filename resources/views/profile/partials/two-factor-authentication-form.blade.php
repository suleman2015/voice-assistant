<section>
    <header class="mb-4">
        <h2 class="h5 text-dark">
            {{ __('Two-Factor Authentication') }}
        </h2>
        <p class="text-muted small">
            {{ __('Add an extra layer of security by requiring a one-time code when signing in.') }}
        </p>
    </header>

    @if (session('status') === 'two-factor-enabled')
        <div class="alert alert-success small mb-3" role="alert">
            {{ __('Two-factor authentication is now enabled.') }}
        </div>
    @elseif (session('status') === 'two-factor-disabled')
        <div class="alert alert-warning small mb-3" role="alert">
            {{ __('Two-factor authentication has been disabled.') }}
        </div>
    @elseif (session('status') === 'two-factor-already-enabled')
        <div class="alert alert-info small mb-3" role="alert">
            {{ __('Two-factor authentication is already enabled.') }}
        </div>
    @elseif (session('status') === 'two-factor-not-enabled')
        <div class="alert alert-info small mb-3" role="alert">
            {{ __('Two-factor authentication is already disabled.') }}
        </div>
    @endif

    @if (! $user->google2fa_enabled)
        <p class="text-muted small mb-3">
            {{ __('Use an authenticator app such as Google Authenticator or Authy to scan a QR code and generate verification codes.') }}
        </p>
        <form method="post" action="{{ route('profile.two-factor.enable') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Enable Two-Factor Authentication') }}
            </button>
        </form>
    @else
        <p class="text-muted small mb-3">
            {{ __('Two-factor authentication is currently active on your account.') }}
        </p>
        <form method="post" action="{{ route('profile.two-factor.disable') }}" onsubmit="return confirm('{{ __('Are you sure you want to disable two-factor authentication?') }}');">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger">
                {{ __('Disable Two-Factor Authentication') }}
            </button>
        </form>
    @endif

    @php
        $twoFactorSecret = session('two_factor_secret') ?? $user->google2fa_secret;
        $twoFactorQr = session('two_factor_qr');
    @endphp

    @if ($twoFactorSecret && $twoFactorQr)
        <hr class="my-4">
        <h3 class="h6 text-dark">
            {{ __('Finish Setup') }}
        </h3>
        <p class="text-muted small mb-3">
            {{ __('Scan this QR code with your authenticator app, or enter the secret key manually.') }}
        </p>
        <div class="text-center mb-3">
            <img src="{{ $twoFactorQr }}" alt="{{ __('Two-factor QR code') }}" class="img-fluid">
        </div>
        <div class="bg-light border rounded p-2 text-center">
            <code class="small mb-0">{{ $twoFactorSecret }}</code>
        </div>
        <p class="text-muted small mt-3">
            {{ __('After scanning, enter the generated code during your next sign in to verify everything is working.') }}
        </p>
    @endif
</section>

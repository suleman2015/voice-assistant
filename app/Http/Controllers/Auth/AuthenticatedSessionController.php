<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Users\Models\User;
use PragmaRX\Google2FA\Google2FA;

class AuthenticatedSessionController extends Controller
{
    private const SESSION_USER_KEY = 'two_factor:user:id';
    private const SESSION_REMEMBER_KEY = 'two_factor:remember';

    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $this->forgetTwoFactorSession($request);

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /** @var \Modules\Users\Models\User $user */
        $user = $request->authenticate();

        if ($user->google2fa_enabled && $user->google2fa_secret) {
            $request->session()->put(self::SESSION_USER_KEY, $user->getKey());
            $request->session()->put(self::SESSION_REMEMBER_KEY, $request->boolean('remember'));

            return redirect()->route('two-factor.challenge');
        }

        return $this->completeLogin($request, $user, $request->boolean('remember'));
    }

    /**
     * Show the two-factor challenge form.
     */
    public function showTwoFactorChallenge(Request $request): RedirectResponse|View
    {
        if (! $request->session()->has(self::SESSION_USER_KEY)) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the provided two-factor code and complete login.
     */
    public function verifyTwoFactorChallenge(Request $request, Google2FA $google2fa): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $userId = $request->session()->get(self::SESSION_USER_KEY);

        if (! $userId) {
            return redirect()->route('login');
        }

        /** @var User|null $user */
        $user = User::find($userId);

        if (! $user) {
            $this->forgetTwoFactorSession($request);

            return redirect()->route('login')->withErrors([
                'email' => __('auth.user'),
            ]);
        }

        $code = preg_replace('/\s+/', '', $request->string('code')->toString());

        if (! $user->google2fa_enabled || ! $user->google2fa_secret) {
            $remember = (bool) $request->session()->pull(self::SESSION_REMEMBER_KEY, false);
            $this->forgetTwoFactorSession($request);

            return $this->completeLogin($request, $user, $remember);
        }

        if (! $google2fa->verifyKey($user->google2fa_secret, $code)) {
            throw ValidationException::withMessages([
                'code' => __('The provided two-factor authentication code is invalid.'),
            ]);
        }

        $remember = (bool) $request->session()->pull(self::SESSION_REMEMBER_KEY, false);
        $this->forgetTwoFactorSession($request);

        return $this->completeLogin($request, $user, $remember);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Complete the login for the given user.
     */
    protected function completeLogin(Request $request, AuthenticatableContract $user, bool $remember = false): RedirectResponse
    {
        Auth::login($user, $remember);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Clear pending two-factor session data.
     */
    protected function forgetTwoFactorSession(Request $request): void
    {
        $request->session()->forget([self::SESSION_USER_KEY, self::SESSION_REMEMBER_KEY]);
    }
}

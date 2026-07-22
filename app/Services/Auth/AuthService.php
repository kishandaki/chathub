<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Auth\LoginSecurityService;
use App\Services\Auth\TwoFactorService;

class AuthService
{
    public function __construct(
        private LoginSecurityService $security,
        private TwoFactorService $twoFactor,
    ) {}

    public function attempt(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $this->security->recordFailedAttempt($request, null, 'User not found');
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        if ($this->security->isLocked($user)) {
            return redirect()->route('account.locked')->with('lockedUntil', $user->locked_until);
        }

        if (Hash::check($request->password, $user->password)) {
            return $this->onValidCredentials($request, $user);
        }

        $this->security->recordFailedAttempt($request, $user, 'Invalid password');
        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

    private function onValidCredentials(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        if ($user->status !== 'active') {
            $this->security->recordFailedAttempt($request, $user, 'Account inactive');
            return back()->withErrors(['email' => 'Your account is not active. Please contact support.'])->onlyInput('email');
        }

        $this->security->resetFailedAttempts($user);
        $this->security->recordLogin($request, $user, 'success');

        Auth::login($user, (bool) $request->filled('remember'));
        $request->session()->regenerate();

        $user->update([
            'last_login_at' => now(),
            'last_active_at' => now(),
        ]);

        if ($user->mfa_enabled) {
            $this->twoFactor->generateAndSend($user, $request);
            return redirect()->route('two-factor');
        }

        return redirect()->intended('/dashboard');
    }
}
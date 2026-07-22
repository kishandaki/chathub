<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function __construct(private TwoFactorService $twoFactor) {}

    public function showForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = Auth::user();

        if (!$user->mfa_enabled) {
            return redirect()->intended('/dashboard');
        }

        if ($this->twoFactor->verify($user, $request->code)) {
            session(['two_factor_verified' => true]);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'Invalid or expired code. Please try again.']);
    }

    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $this->twoFactor->resend($user, $request);

        return back()->with('status', 'A new code has been sent.');
    }
}
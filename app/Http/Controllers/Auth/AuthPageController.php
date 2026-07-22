<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthPageController extends Controller
{
    public function sessionExpired()
    {
        return view('auth.session-expired');
    }

    public function accountLocked(Request $request)
    {
        return view('auth.account-locked', [
            'lockedUntil' => $request->session()->get('locked_until'),
        ]);
    }

    public function forbidden()
    {
        return view('errors.403');
    }

    public function notFound()
    {
        return view('errors.404');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function otpVerify()
    {
        return view('auth.otp-verify');
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function otpResend(Request $request)
    {
        return redirect()->route('otp.verify')->with('status', 'A new code has been sent.');
    }
}

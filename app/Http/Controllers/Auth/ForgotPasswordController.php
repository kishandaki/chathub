<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __construct(private PasswordResetService $passwords) {}

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $this->passwords->sendResetLink($request->only('email'));

        return back()->with('status', 'We\'ve sent you a password reset link. Please check your inbox.');
    }
}
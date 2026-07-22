<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function __construct(private PasswordResetService $passwords) {}

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $this->passwords->reset($request->only('email', 'password', 'password_confirmation', 'token'));

        return redirect()->route('login')->with('status', 'Your password has been reset. Please sign in.');
    }
}
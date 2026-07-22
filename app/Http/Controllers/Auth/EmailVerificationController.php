<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function __construct(private EmailVerificationService $verification) {}

    public function showVerifyForm()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = \App\Models\User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->email))) {
            return redirect()->route('verification.notice')->withErrors(['email' => 'Invalid verification link.']);
        }

        if ($user->email_verified_at) {
            return redirect()->route('login');
        }

        $this->verification->markAsVerified($user);

        return redirect()->route('login')->with('status', 'Your email has been verified. Please sign in.');
    }

    public function resend(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            $this->verification->sendVerification($user, $request);
        }

        return back()->with('status', 'A new verification link has been sent.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTwoFactorIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->mfa_enabled && !$request->session()->get('two_factor_verified')) {
            return redirect()->route('two-factor');
        }

        return $next($request);
    }
}
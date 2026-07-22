<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureAccountIsNotLocked
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->locked_until && $user->locked_until->isFuture()) {
            return redirect()->route('account.locked')->with('lockedUntil', $user->locked_until);
        }

        return $next($request);
    }
}
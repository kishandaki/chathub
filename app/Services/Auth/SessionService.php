<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionService
{
    public function trackActivity(User $user, Request $request): void
    {
        $user->update(['last_active_at' => now()]);
    }

    public function isExpired(User $user): bool
    {
        if (!$user->last_active_at) {
            return true;
        }

        $timeout = config('session.lifetime', 120);
        return $user->last_active_at->addMinutes($timeout)->isPast();
    }

    public function invalidateSession(Request $request): void
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginSecurityService
{
    private const MAX_FAILED_ATTEMPTS = 5;
    private const LOCK_MINUTES = 15;

    public function isLocked(User $user): bool
    {
        return $user->locked_until !== null && $user->locked_until->isFuture();
    }

    public function recordFailedAttempt(Request $request, ?User $user, string $reason): void
    {
        if ($user) {
            $user->increment('failed_login_attempts');

            if ($user->failed_login_attempts >= self::MAX_FAILED_ATTEMPTS) {
                $user->update([
                    'locked_until' => now()->addMinutes(self::LOCK_MINUTES),
                    'status' => 'locked',
                ]);

                DB::table('account_lock_logs')->insert([
                    'user_id' => $user->id,
                    'locked_by' => null,
                    'reason' => $reason,
                    'failed_attempts' => $user->failed_login_attempts,
                    'locked_until' => now()->addMinutes(self::LOCK_MINUTES),
                    'unlocked_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        DB::table('login_histories')->insert([
            'user_id' => $user?->id,
            'email' => $request->email,
            'status' => 'failed',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'failure_reason' => $reason,
            'logged_in_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function recordLogin(Request $request, User $user, string $status): void
    {
        DB::table('login_histories')->insert([
            'user_id' => $user->id,
            'email' => $user->email,
            'status' => $status,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'failure_reason' => null,
            'logged_in_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function resetFailedAttempts(User $user): void
    {
        $user->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }
}
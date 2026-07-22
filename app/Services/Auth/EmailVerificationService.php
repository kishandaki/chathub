<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailVerificationService
{
    public function sendVerification(User $user, Request $request): void
    {
        $token = \Illuminate\Support\Str::random(64);

        DB::table('email_verification_tokens')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'token' => $token,
                'expires_at' => now()->addHours(24),
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // In production, send verification email with signed URL.
    }

    public function markAsVerified(User $user): void
    {
        $user->update(['email_verified_at' => now()]);

        DB::table('email_verification_tokens')
            ->where('user_id', $user->id)
            ->update(['verified_at' => now()]);
    }
}
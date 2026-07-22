<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TwoFactorService
{
    public function generateAndSend(User $user, Request $request): void
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('two_factor_tokens')->insert([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'verified_at' => null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // In a real app, send code via email/SMS here.
        // For now, we store it in session for testing.
        session(['two_factor_code' => $code]);
    }

    public function verify(User $user, string $code): bool
    {
        $token = DB::table('two_factor_tokens')
            ->where('user_id', $user->id)
            ->where('code', $code)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$token) {
            return false;
        }

        DB::table('two_factor_tokens')
            ->where('id', $token->id)
            ->update([
                'verified_at' => now(),
                'updated_at' => now(),
            ]);

        return true;
    }

    public function resend(User $user, Request $request): void
    {
        $this->generateAndSend($user, $request);
    }
}
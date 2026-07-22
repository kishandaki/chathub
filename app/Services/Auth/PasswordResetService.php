<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetService
{
    public function sendResetLink(array $data): void
    {
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $token = \Illuminate\Support\Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => $token,
                    'created_at' => now(),
                ]
            );

            // In production, send email with reset link containing token.
        }
    }

    public function reset(array $data): void
    {
        $reset = DB::table('password_reset_tokens')
            ->where('email', $data['email'])
            ->first();

        if (!$reset || !\Illuminate\Support\Facades\Hash::check($data['token'], $reset->token)) {
            abort(404);
        }

        $user = User::where('email', $data['email'])->firstOrFail();

        $user->update([
            'password' => Hash::make($data['password']),
            'password_changed_at' => now(),
        ]);

        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
    }
}
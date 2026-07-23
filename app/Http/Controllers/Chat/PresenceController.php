<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatUserPresence;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function online(): JsonResponse
    {
        ChatUserPresence::updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'online', 'last_active_at' => now()]
        );

        return response()->json(null, 204);
    }

    public function offline(): JsonResponse
    {
        ChatUserPresence::updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'offline', 'last_active_at' => now()]
        );

        return response()->json(null, 204);
    }

    public function show(int $userId): JsonResponse
    {
        $presence = ChatUserPresence::where('user_id', $userId)->first();

        return response()->json(['data' => $presence], 200);
    }
}
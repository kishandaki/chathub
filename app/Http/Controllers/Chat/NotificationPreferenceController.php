<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatNotificationPreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationPreferenceController extends Controller
{
    public function show(): JsonResponse
    {
        $preferences = ChatNotificationPreference::firstOrCreate(
            ['user_id' => Auth::id()],
            []
        );

        return response()->json(['data' => $preferences], 200);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'push_enabled' => 'nullable|boolean',
            'email_enabled' => 'nullable|boolean',
            'in_app_enabled' => 'nullable|boolean',
            'sound_enabled' => 'nullable|boolean',
            'quiet_hours_start' => 'nullable|date_format:H:i',
            'quiet_hours_end' => 'nullable|date_format:H:i',
        ]);

        $preferences = ChatNotificationPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return response()->json(['data' => $preferences], 200);
    }
}
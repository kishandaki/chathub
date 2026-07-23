<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatUserDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(): JsonResponse
    {
        $devices = ChatUserDevice::where('user_id', Auth::id())->get();

        return response()->json(['data' => $devices], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'device_name' => 'required|string|max:255',
            'device_type' => 'nullable|string|max:50',
            'push_token' => 'nullable|string|max:255',
        ]);

        $device = ChatUserDevice::create([
            'user_id' => Auth::id(),
            'device_name' => $data['device_name'],
            'device_type' => $data['device_type'] ?? null,
            'push_token' => $data['push_token'] ?? null,
            'is_active' => true,
        ]);

        return response()->json(['data' => $device], 201);
    }

    public function revoke(ChatUserDevice $device): JsonResponse
    {
        $device->update(['is_active' => false, 'updated_by' => Auth::id()]);

        return response()->json(null, 204);
    }
}
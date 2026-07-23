<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // Auth routes are in routes/auth.php
});

require __DIR__.'/auth.php';

// Broadcasting routes (Reverb / Socket.io handshake)
Broadcast::routes(['middleware' => ['auth']]);

// Reverb status endpoint
Route::get('/reverb/status', function () {
    return response()->json(['ok' => true]);
});

require __DIR__.'/channels.php';

Route::middleware('protected')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\ChatHubController::class, 'index'])->name('dashboard');
});

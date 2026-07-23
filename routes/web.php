<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // Auth routes are in routes/auth.php
});

require __DIR__.'/auth.php';

Route::middleware('protected')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\ChatHubController::class, 'index'])->name('dashboard');
});

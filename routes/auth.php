<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\TwoFactorController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset.password');

    Route::get('/verify-email', [EmailVerificationController::class, 'showVerifyForm'])->name('verification.notice');
    Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

    Route::get('/two-factor', [TwoFactorController::class, 'showForm'])->name('two-factor');
    Route::post('/two-factor', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::post('/two-factor/resend', [TwoFactorController::class, 'resend'])->name('two-factor.resend');

    Route::get('/session-expired', [AuthPageController::class, 'sessionExpired'])->name('session.expired');
    Route::get('/account-locked', [AuthPageController::class, 'accountLocked'])->name('account.locked');
    Route::get('/register', [AuthPageController::class, 'register'])->name('register');
    Route::get('/otp-verify', [AuthPageController::class, 'otpVerify'])->name('otp.verify');
    Route::post('/otp-verify/resend', [AuthPageController::class, 'otpResend'])->name('otp.resend');
    Route::get('/change-password', [AuthPageController::class, 'changePassword'])->name('change.password');
    Route::get('/403', [AuthPageController::class, 'forbidden'])->name('forbidden');
    Route::get('/404', [AuthPageController::class, 'notFound'])->name('not-found');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});
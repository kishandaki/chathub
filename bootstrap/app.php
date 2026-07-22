<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'account.active' => \App\Http\Middleware\EnsureAccountIsActive::class,
            'account.not_locked' => \App\Http\Middleware\EnsureAccountIsNotLocked::class,
            'email.verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'twofactor.verified' => \App\Http\Middleware\EnsureTwoFactorIsVerified::class,
            'track.activity' => \App\Http\Middleware\TrackUserActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();

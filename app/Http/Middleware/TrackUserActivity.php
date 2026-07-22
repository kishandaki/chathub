<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Auth\SessionService;

class TrackUserActivity
{
    public function __construct(private SessionService $sessions) {}

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            $this->sessions->trackActivity($request->user(), $request);
        }

        return $next($request);
    }
}
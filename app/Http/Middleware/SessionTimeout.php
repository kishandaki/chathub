<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Auth\SessionService;

class SessionTimeout
{
    public function __construct(private SessionService $sessions) {}

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $this->sessions->isExpired($user)) {
            $this->sessions->invalidateSession($request);
            return redirect()->route('session.expired');
        }

        $this->sessions->trackActivity($user, $request);

        return $next($request);
    }
}
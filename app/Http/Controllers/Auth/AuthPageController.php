<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthPageController extends Controller
{
    public function sessionExpired()
    {
        return view('auth.session-expired');
    }

    public function accountLocked(Request $request)
    {
        return view('auth.account-locked', [
            'lockedUntil' => $request->session()->get('locked_until'),
        ]);
    }

    public function forbidden()
    {
        return view('errors.403');
    }

    public function notFound()
    {
        return view('errors.404');
    }
}
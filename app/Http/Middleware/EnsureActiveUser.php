<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->status === 'blocked') {
            Auth::logout();

            return redirect()->route('login')->with('error', 'Your account is blocked. Please contact the lab assistant.');
        }

        return $next($request);
    }
}

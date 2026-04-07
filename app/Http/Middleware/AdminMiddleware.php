<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in or not an admin, redirect to home
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/');
        }

        return $next($request);
    }
}

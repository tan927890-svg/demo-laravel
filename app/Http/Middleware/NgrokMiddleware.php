<?php

namespace App\Http\Middleware;

use Closure;

class NgrokMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('x-forwarded-host')) {
            $request->headers->set('Host', $request->header('x-forwarded-host'));
        }
        return $next($request);
    }
}
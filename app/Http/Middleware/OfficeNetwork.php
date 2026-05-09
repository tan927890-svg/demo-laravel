<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OfficeNetwork
{
    public function handle(Request $request, Closure $next)
{
    // Bỏ qua khi dev local
    if (app()->environment('local')) {
        return $next($request);
    }

    $ip = $request->ip();

    if (!str_starts_with($ip, '192.168.1.')) {
        abort(403, 'Bạn phải kết nối WiFi văn phòng để chấm công.');
    }

    return $next($request);
}
}
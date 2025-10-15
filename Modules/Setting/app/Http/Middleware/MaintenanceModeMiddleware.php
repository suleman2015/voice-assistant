<?php

namespace Modules\Setting\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isMaintenance = setting('maintenance_mode') == '1';

        if ($request->is('login') || $request->is('logout')) {
            return $next($request);
        }

        if (!$isMaintenance) {
            return $next($request);
        }

        if (!Auth::check()) {
            abort(503, 'The site is currently under maintenance.');
        }

        if (!Auth::user()->hasRole('superadmin')) {
            abort(503, 'The site is currently under maintenance.');
        }

        return $next($request);
    }
}

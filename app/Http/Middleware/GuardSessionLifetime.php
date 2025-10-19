<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
    

class GuardSessionLifetime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // If user is logged in via 'web' guard
        if (Auth::guard('customer')->check()) {
            Config::set('session.lifetime', env('WEB_SESSION_LIFETIME', 240)); // 240 minutes
            Config::set('session.cookie', env('WEB_SESSION_COOKIE', 'web_session'));
        }

        // If user is logged in via 'admin' guard
        if (Auth::guard('web')->check()) {
            Config::set('session.lifetime', env('ADMIN_SESSION_LIFETIME', 360)); // 360 minutes
            Config::set('session.cookie', env('ADMIN_SESSION_COOKIE', 'admin_session'));
        }

        return $next($request);
    }
}

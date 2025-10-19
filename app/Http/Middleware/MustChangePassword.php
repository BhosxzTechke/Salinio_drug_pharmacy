<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

        public function handle($request, Closure $next)
        {

                /// if naka 1 ung value sa DB then redirect sa password change form
                if (auth()->user()->must_change_password) {

                            return redirect()->route('password.change');
                        }


                        
            return $next($request);
        }
}


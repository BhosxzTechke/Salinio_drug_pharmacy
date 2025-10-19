<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;    

class CustomerMiddleware
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

            /**
     * Handle an incoming request.
     */
        // Use the 'customer' guard (replace 'customer' with your actual guard name)
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            // Not logged in
            return redirect()->route('login');
        }

        // Optional: check role if you store roles in the customer table
        if (property_exists($customer, 'role') && $customer->role !== 'customer') {
            return redirect('/'); // or abort(403)
        }

        return $next($request);
    }



}

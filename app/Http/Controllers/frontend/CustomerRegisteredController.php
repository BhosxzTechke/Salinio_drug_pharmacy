<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Customer;

class CustomerRegisteredController extends Controller
{
    //


        /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function create(): View
    {
        return view('Ecommerce.auth.CustomerRegister');
    }
                
    public function customerRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Customer::class],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string'],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $Customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'city' => null, // Set city to null
            'added_by_staff' => '0',
        ]);

        event(new Registered($Customer));


        // Use this instead because we have multiple guards

       Auth::guard('customer')->login($Customer);

        return redirect(RouteServiceProvider::CUSTOMER_HOME);
    }

    
















}



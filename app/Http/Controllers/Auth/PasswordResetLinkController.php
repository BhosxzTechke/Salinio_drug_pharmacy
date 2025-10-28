<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('Ecommerce.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
            public function store(Request $request): RedirectResponse
            {
                // Manual validation to prevent automatic error display
                $validator = \Validator::make($request->all(), [
                    'email' => ['required', 'email'],
                ]);

                if ($validator->fails()) {
                    // Optionally, you can redirect silently without showing errors
                    return back()->with('status', 'If your email exists, a reset link will be sent.');
                }

                // Attempt to send the password reset link using the "customers" broker
                $status = Password::broker('customers')->sendResetLink(
                    $request->only('email')
                );

                // Always return the same message to prevent exposing user existence
                return back()->with('status', 'If your email exists, a reset link will be sent.');
            }

    

}

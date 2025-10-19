<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    //

    public function ContactShow(){
        return view('Ecommerce.EcommercePage.Contact');
    }

    public function ContactMessage(Request $request){
        // Validate the incoming request data
        $validated = $request->validate([
            'email' => 'required|email',
            // 'subject' => 'required|string|max:255',
            // 'message' => 'required|string',
        ]);
        
        // Use the email from the form as the recipient
        Mail::to($validated['email'])->send(new ContactMail($validated));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}

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

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $details = [
            'title' => 'New Contact Message',
            'body' => $request->message,
            'from' => $request->email,
            'name' => $request->name,
        ];

        Mail::send('emails.contact', $details, function ($message) use ($request) {
            $message->to('danmichaelantiquina9@gmail.com')
                    ->subject('New Contact Message from ' . $request->name);
        });


        

        return back()->with('success', 'Message sent successfully!');
    }




}

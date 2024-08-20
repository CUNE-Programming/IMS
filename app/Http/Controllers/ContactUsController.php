<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController
{
    public function create()
    {
        return view('contact-us.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Send email to the admin
        Mail::to(config('mail.from.address'))->send(new ContactUsMail($validated['email'], $validated['message']));
    }
}

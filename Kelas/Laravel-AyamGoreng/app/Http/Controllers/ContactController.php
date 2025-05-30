<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }
    
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Store in database - uncomment if you want to store messages
        /*
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        */
        
        // Send email - uncomment when you have set up mail configuration
        /*
        Mail::to('admin@example.com')->send(new ContactFormMail([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]));
        */
        
        return back()->with('success', 'Pesan berhasil dikirim. Kami akan menghubungi Anda segera.');
    }
}
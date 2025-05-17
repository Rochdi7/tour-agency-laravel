<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class NewsletterController extends Controller
{
    /**
     * Handle newsletter subscription
     */
    public function subscribe(Request $request)
    {
        // Validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Save the email to the database
        \DB::table('newsletters')->insert([
            'email' => $request->email,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Send the subscription confirmation email
        Mail::to($request->email)->send(new NewsletterMail(
            'Newsletter Subscription Successful',
            'Thank you for subscribing to our newsletter. You will receive updates soon.'
        ));
        

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}

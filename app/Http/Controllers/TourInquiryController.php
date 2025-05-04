<?php

namespace App\Http\Controllers;

use App\Models\Tour; // Import your Tour model (adjust namespace if needed)
use Illuminate\Http\Request;
use App\Mail\TourInquiryMail; // <-- We'll create this new Mailable
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TourInquiryController extends Controller
{
    /**
     * Handle the tour inquiry form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tour  $tour  // Using route model binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Tour $tour)
    {
        // 1. Validate the incoming request data
        // Adapt fields based on the form we'll create below
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'nationality'   => 'required|string|max:100', // Using 'nationality' for consistency
            'phone'         => 'required|string|max:25',
            'arrival_date'  => 'required|date|after_or_equal:today',
            'duration_days' => 'required|integer|min:1', // Or maybe remove if duration is fixed by the tour? Adjust as needed.
            'adults'        => 'required|integer|min:1',
            'children'      => 'nullable|integer|min:0',
            'inquiry_message' => 'required|string|min:10|max:5000', // Renamed from travel_ideas, made required
        ]);

        // Add tour title to the data for the email
        // No need for a hidden field in the form because we have $tour here
        $validatedData['tour_title'] = $tour->title;
        $validatedData['tour_url'] = route('tours.show', $tour); // Add URL for convenience

        // 2. Process the data (Send Email)
        try {
            $adminEmail = config('mail.from.address'); // Get admin email from .env

            if (!$adminEmail || filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
                 Log::error('Admin email (MAIL_FROM_ADDRESS) is not configured properly for Tour Inquiry.');
                 return back()->with('error', 'Inquiry could not be sent due to a server configuration issue.')->withInput();
            }

            // Send email using the new Mailable, passing validated data and the tour
            Mail::to($adminEmail)->send(new TourInquiryMail($validatedData, $tour));

            return back()->with('success', 'Your inquiry about "' . $tour->title . '" has been sent successfully! We will contact you soon.');

        } catch (\Exception $e) {
             Log::error('Tour Inquiry mail sending failed for tour ' . $tour->id . ': ' . $e->getMessage());
             Log::error($e);

             return back()->with('error', 'Sorry, there was an issue sending your inquiry. Please try again later.')->withInput();
        }
    }
}
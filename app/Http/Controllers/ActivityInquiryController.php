<?php

namespace App\Http\Controllers;

use App\Models\Activity; // Import your Activity model (adjust namespace if needed)
use Illuminate\Http\Request;
use App\Mail\ActivityInquiryMail; // <-- We'll create this new Mailable
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ActivityInquiryController extends Controller
{
    /**
     * Handle the activity inquiry form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity  // Using route model binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Activity $activity)
    {
        // 1. Validate the incoming request data - MATCHING THE FORM WE WILL CREATE
        // Using consistent field names like 'nationality' and 'inquiry_message'
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'nationality'   => 'required|string|max:100',       // Renamed from 'country'
            'phone'         => 'required|string|max:25',
            // Consider if arrival_date/duration make sense for activities, adjust if needed
            'arrival_date'  => 'nullable|date|after_or_equal:today', // Made nullable, adjust as needed
            'duration_days' => 'nullable|integer|min:1',           // Made nullable, adjust as needed
            'adults'        => 'required|integer|min:1',
            'children'      => 'nullable|integer|min:0',
            'inquiry_message' => 'required|string|min:10|max:5000', // Renamed from 'message'
        ]);

        // Add activity title and URL to the data for the email
        $validatedData['activity_title'] = $activity->title;
        // Ensure you have a route named 'activities.show'
        $validatedData['activity_url'] = route('activities.show', $activity);

        // 2. Process the data (Send Email)
        try {
            $adminEmail = config('mail.from.address');

            if (!$adminEmail || filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
                 Log::error('Admin email (MAIL_FROM_ADDRESS) is not configured properly for Activity Inquiry.');
                 return back()->with('error', 'Inquiry could not be sent due to a server configuration issue.')->withInput();
            }

            // Send email using the new Mailable
            Mail::to($adminEmail)->send(new ActivityInquiryMail($validatedData, $activity));

            return back()->with('success', 'Your inquiry about "' . $activity->title . '" has been sent successfully! We will contact you soon.');

        } catch (\Exception $e) {
             Log::error('Activity Inquiry mail sending failed for activity ' . $activity->id . ': ' . $e->getMessage());
             Log::error($e);

             return back()->with('error', 'Sorry, there was an issue sending your inquiry. Please try again later.')->withInput();
        }
    }
}
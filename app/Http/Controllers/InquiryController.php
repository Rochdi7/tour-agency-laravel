<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Trip;
use App\Models\Activity; // ** Import Activity model **
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceived; // ** Use the new Mailable **
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Arr; // Import Arr utility

class InquiryController extends Controller
{
    // --- Shared Validation Rules ---
    protected function baseInquiryRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50', // Kept required for consistency, make nullable if needed
            'country' => 'required|string|max:255', // Kept required, make nullable if needed
            'message' => 'required|string|max:5000|min:10',
        ];
    }

    // --- Specific Validation Rules ---
    protected function tourTripActivityRules(): array
    {
        return [
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            // Hidden field name might vary, handled in specific methods
        ];
    }

    protected function contactFormRules(): array
    {
        // Example: Maybe contact form has a specific subject field
         // 'subject' => 'nullable|string|max:255',
         return []; // No extra rules needed here currently
    }

    // ========================================
    //  Public Methods for Each Form Type
    // ========================================

    /**
     * Store a new TOUR inquiry.
     */
    public function storeTourInquiry(Request $request, Tour $tour) // Uses Route Model Binding
    {
        $specificRules = ['tour_title' => 'required|string']; // Hidden field
        $validatedData = $request->validate(array_merge(
            $this->baseInquiryRules(),
            $this->tourTripActivityRules(),
            $specificRules
        ));

        $subject = "New Tour Inquiry: " . $validatedData['tour_title'];
        // Add context for the email view
        $validatedData['subject_type'] = 'tour';
        $validatedData['subject_title'] = $tour->title; // Use actual model title
        $validatedData['subject_url'] = route('tours.show', $tour->slug); // URL to the tour

        return $this->processInquiry(
            $validatedData,
            $subject,
            route('tours.show', $tour->slug) // Redirect back route
        );
    }

    /**
     * Store a new TRIP inquiry.
     */
    public function storeTripInquiry(Request $request, string $slug) // Finds Trip manually
    {
        $trip = Trip::where('slug', $slug)->firstOrFail();
        $specificRules = ['trip_title' => 'required|string']; // Hidden field
        $validatedData = $request->validate(array_merge(
            $this->baseInquiryRules(),
            $this->tourTripActivityRules(),
            $specificRules
        ));

        $subject = "New Trip Inquiry: " . $validatedData['trip_title'];
        // Add context
        $validatedData['subject_type'] = 'trip';
        $validatedData['subject_title'] = $trip->title;
        $validatedData['subject_url'] = route('trips.show', $trip->slug);

        return $this->processInquiry(
            $validatedData,
            $subject,
            route('trips.show', $trip->slug) // Redirect back route
        );
    }

    /**
     * Store a new ACTIVITY inquiry.
     * ACTION: Create the route for this in web.php
     * Example Route: Route::post('/activities/{activity}/inquire', [InquiryController::class, 'storeActivityInquiry'])->name('activity.inquiry');
     * Assuming route model binding works for Activity model
     */
    public function storeActivityInquiry(Request $request, Activity $activity)
    {
        $specificRules = ['activity_title' => 'required|string']; // Hidden field in activity form
        $validatedData = $request->validate(array_merge(
            $this->baseInquiryRules(),
            $this->tourTripActivityRules(), // Activities might also need adults/children
            $specificRules
        ));

        $subject = "New Activity Inquiry: " . $validatedData['activity_title'];
        // Add context
        $validatedData['subject_type'] = 'activity';
        $validatedData['subject_title'] = $activity->title; // Assuming Activity has a title
        // ACTION: Ensure you have a named route for showing activity details
        // $validatedData['subject_url'] = route('activities.show', $activity->id); // Example

        // ACTION: Ensure you have a named route for showing activity details to redirect back
        return $this->processInquiry(
            $validatedData,
            $subject,
            url()->previous() // Simple redirect back, or use named route if available
            // route('activities.show', $activity->id)
        );
    }

     /**
     * Store a new CONTACT form submission.
     * ACTION: Create the route for this in web.php
     * Example Route: Route::post('/contact/submit', [InquiryController::class, 'storeContactInquiry'])->name('contact.submit');
     */
    public function storeContactInquiry(Request $request)
    {
        // No adults/children needed, potentially add a subject field if your contact form has one
        $validatedData = $request->validate(array_merge(
            $this->baseInquiryRules(),
            $this->contactFormRules()
            // Add ['subject' => 'nullable|string|max:255'] here if form has subject
        ));

        $subject = "New Contact Form Submission";
        if (!empty($validatedData['subject'])) { // Append subject if provided
             $subject .= ": " . $validatedData['subject'];
        }
        // Add context - no specific item attached
        $validatedData['subject_type'] = 'contact form';


        // ACTION: Decide where to redirect after contact form submission (e.g., back, or to a thank you page)
        return $this->processInquiry(
            $validatedData,
            $subject,
            route('contact') // Redirect back to contact page
            // Or create a 'thank you' route/view: route('contact.thanks')
        );
    }


    // ========================================
    //  Private Helper Method for Processing
    // ========================================

    /**
     * Handles the core processing (email/DB save) for any inquiry.
     *
     * @param array $validatedData The validated data from the specific store method.
     * @param string $emailSubject The subject line for the admin email.
     * @param string $redirectRoute The route/URL to redirect back to on success/error.
     * @return \Illuminate\Http\RedirectResponse
     */
    private function processInquiry(array $validatedData, string $emailSubject, string $redirectRoute)
    {
        // --- Processing Logic (Send Email and/or Save to DB) ---
        try {
            // 1. Send Email Notification to Admin
            $adminEmail = config('mail.admin_address', 'admin@yourapp.com'); // Get admin email address
            Mail::to($adminEmail)->send(new InquiryReceived($validatedData, $emailSubject));

            // 2. (Optional) Save Inquiry to Database
            /*
            try {
                // Ensure you have an Inquiry model & migration
                // Add columns like 'subject_type', 'subject_title', 'subject_link', 'inquirable_id', 'inquirable_type' etc.
                // $inquiryDataForDb = Arr::except($validatedData, ['_token']); // Remove token if present
                // Inquiry::create($inquiryDataForDb);

            } catch (\Exception $dbException) {
                Log::error("Failed to save inquiry to DB: " . $dbException->getMessage(), ['data' => $validatedData]);
                // Decide if this is critical. Maybe still redirect with success if email sent?
            }
            */

            // 3. Redirect on Success
            return redirect($redirectRoute)->with('success', 'Your inquiry has been sent successfully! We will get back to you soon.');

        } catch (\Exception $e) {
            // Log the error
            Log::error("Inquiry processing failed: " . $e->getMessage(), [
                'subject' => $emailSubject,
                'data' => $validatedData, // Log the data that failed
                'exception' => $e
            ]);

            // Redirect back with an error message and repopulate form
            return redirect($redirectRoute)->with('error', 'Sorry, there was an error sending your inquiry. Please try again later.')->withInput(
                // Don't re-fill password fields if you ever add them
                Arr::except($validatedData, ['password', 'password_confirmation'])
            );
        }
    }
    public function storeUnifiedInquiry(Request $request, string $type, string $slug)
{
    // Détermine le modèle cible
    $modelClass = match ($type) {
        'tours' => \App\Models\Tour::class,
        'trips' => \App\Models\Trip::class,
        'activities' => \App\Models\Activity::class,
        default => abort(404),
    };

    $item = $modelClass::where('slug', $slug)->firstOrFail();

    // Validation
    $specificRules = [$type . '_title' => 'required|string'];
    $validatedData = $request->validate(array_merge(
        $this->baseInquiryRules(),
        $this->tourTripActivityRules(),
        $specificRules
    ));

    // Email subject
    $subject = "New Inquiry: " . $validatedData[$type . '_title'];
    $validatedData['subject_type'] = $type;
    $validatedData['subject_title'] = $item->title;
    $validatedData['subject_url'] = url()->current(); // Or generate route based on $type if needed

    return $this->processInquiry(
        $validatedData,
        $subject,
        url()->previous()
    );
}

}
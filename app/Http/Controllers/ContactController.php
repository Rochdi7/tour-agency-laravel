<?php

namespace App\Http\Controllers;

// **IMPORTANT: Make sure you are using this generic Request class**
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
// Use your model if you decide to save submissions
// use App\Models\ContactSubmission; // Uncomment if saving to DB

class ContactController extends Controller
{
    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request  <-- **Ensure this is NOT a specific Form Request class**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // <-- **Using the generic Request**
    {
        // 1. Validate the incoming request data - RULES MATCHING YOUR FORM'S 'name' ATTRIBUTES
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',         // Matches <input name="name">
            'email'         => 'required|email|max:255',          // Matches <input name="email">
            'nationality'   => 'required|string|max:100',       // Matches <input name="nationality">
            'phone'         => 'required|string|max:25',          // Matches <input name="phone">
            'arrival_date'  => 'required|date|after_or_equal:today', // Matches <input name="arrival_date">
            'duration_days' => 'required|integer|min:1',          // Matches <input name="duration_days">
            'adults'        => 'required|integer|min:1',          // Matches <input name="adults">
            'children'      => 'nullable|integer|min:0',          // Matches <input name="children"> (Optional)
            'travel_ideas'  => 'nullable|string|max:5000',      // Matches <textarea name="travel_ideas"> (Optional)
        ]);

        // --- Optional: Save to database ---
        // If you uncomment this, make sure your ContactSubmission model has
        // protected $fillable = ['name', 'email', 'nationality', ...];
        // and your database table has columns for all these fields.
        /*
        try {
            // Assuming you have created the Model: App\Models\ContactSubmission
             \App\Models\ContactSubmission::create($validatedData);
        } catch (\Exception $e) {
            Log::error('Failed to save contact submission: ' . $e->getMessage());
            // Decide if you want to stop here or still try to send email
            // return back()->with('error', 'Could not save your submission. Please try again.')->withInput();
        }
        */
        // --- End Optional ---


        // 2. Process the data (Send Email)
        try {
            $adminEmail = config('mail.from.address', 'default-admin@example.com');

            if (!$adminEmail || $adminEmail === 'default-admin@example.com' || $adminEmail === 'hello@example.com' || filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
                 Log::error('Admin email (MAIL_FROM_ADDRESS) is not configured properly in .env or config/mail.php. Value: ' . $adminEmail);
                 return back()->with('error', 'Message could not be sent due to a server configuration issue. Please contact support.')->withInput();
            }

            // Pass the CORRECT validated data to the Mailable
            Mail::to($adminEmail)->send(new ContactFormMail($validatedData));

             // Redirect back with success message
             return back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');

        } catch (\Exception $e) {
             Log::error('Contact form mail sending failed: ' . $e->getMessage());
             Log::error($e); // Log full stack trace for detailed debugging if needed

             // Redirect back with a user-friendly error message
             return back()->with('error', 'Sorry, there was an issue sending your message. Please try again later.')->withInput();
        }
    }
}
<?php

// Defines the namespace for the controller. This helps Laravel find the file.
namespace App\Http\Controllers;

// Import necessary classes using the 'use' keyword.
use App\Models\Trip; // Imports the Trip model to interact with the 'trips' database table.
use Illuminate\Http\Request; // Imports the Request class (though not strictly needed in this simplified version, it's good practice to keep if you might add request handling later).
use Illuminate\View\View; // Imports the View class for type hinting (helps code editors understand what the methods return).

// Defines the TripController class, which extends Laravel's base Controller.
class TripController extends Controller
{
    /**
     * Display a listing of the trips (public facing).
     * This method handles the page that shows multiple trips, like your main trips page.
     * Example URL: yourwebsite.com/trips
     *
     * @return \Illuminate\View\View  // Indicates this method returns a View object.
     */
    public function index(): View
    {
        $query = Trip::query();
        $query->with('images');
        $query->latest();
        $trips = $query->paginate(9);

        // This should point to your LISTING view file: resources/views/trips.blade.php
        return view('trips', compact('trips'));
    }

    /**
     * Display the specified trip details (public facing).
     * This method handles the page that shows the details for ONE specific trip.
     * Example URL: yourwebsite.com/trips/my-awesome-trip-slug
     *
     * @param string $slug The unique identifier (slug) for the trip, taken from the URL.
     * @return \Illuminate\View\View // Indicates this method returns a View object.
     */
    public function show(string $slug): View
    {
        $query = Trip::query();
        $query->with(['images', 'itineraryDays']);
        $query->where('slug', $slug);
        $trip = $query->firstOrFail();

        // *** CHANGE THIS LINE ***
        // Point to your DETAIL view file: resources/views/trips-details.blade.php
        return view('trips-details', compact('trip')); // Changed from 'trips.show'
    }

    /*
    |--------------------------------------------------------------------------
    | Admin / CRUD Methods (REMOVED)
    |--------------------------------------------------------------------------
    | The methods for creating, saving, editing, updating, and deleting trips
    | (like store(), update(), destroy(), create(), edit()) are NOT needed here anymore.
    |
    | WHY? Because you are using FILAMENT. Filament's "Resources" (like your TripResource)
    | handle all the logic for managing trips within the admin panel.
    |
    | Keeping this controller focused ONLY on the public website pages makes
    | your code cleaner and easier to understand.
    */

} // End of the TripController class
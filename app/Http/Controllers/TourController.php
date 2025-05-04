<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourImage;
use App\Models\Place;
use App\Models\ItineraryDay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TourController extends Controller
{
    /**
     * Display a listing of unique places (cities) with their tour counts (Destinations Page).
     */
    public function listPlaces()
    {
        $placesData = DB::table('places')
            ->join('place_tour', 'places.id', '=', 'place_tour.place_id')
            ->select(
                'places.name',
                'places.slug',
                'places.image_path',
                DB::raw('COUNT(DISTINCT place_tour.tour_id) as tours_count')
            )
            ->whereNotNull('places.name')
            ->where('places.name', '!=', '')
            ->groupBy('places.name', 'places.slug', 'places.image_path')
            ->orderBy('places.name', 'asc')
            ->paginate(12);

        // Pass the data to the view
        return view('destinations', compact('placesData'));
    }

    /**
     * Display a listing of the resource (tours), optionally filtered by place or search query.
     */
    public function index(Request $request)
    {
        // --- Get Input Values ---
        $placeName = $request->input('place');
        $searchDate = $request->input('searchDate'); // e.g., "2025-04-21"
        $selectedGuests = $request->input('guests'); // e.g., "5"

        // --- Fetch Data for Search Bar Dropdowns (needed for repopulating the form) ---
        $locations = Place::query()
            ->where(function ($query) {
                $query->whereHas('tours')
                    ->orWhereHas('activities'); // Include if searching both
            })
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->distinct()
            ->pluck('name')
            ->unique();

        // --- Build Tour Query Based on Filters ---
        // If you want to search BOTH Tours and Activities, this needs more complex logic
        // For now, focusing on Tours as per the controller's name
        $toursQuery = Tour::query()
            ->with(['firstImage', 'places']) // Eager load necessary relations
            ->withCount('places');

        // Filter by Place Name if provided
        if ($placeName) {
            $toursQuery->whereHas('places', function ($q) use ($placeName) {
                $q->where('name', $placeName);
            });
        }

        // Filter by Date (Month from searchDate matching best_season)
        if ($searchDate) {
            try {
                $date = Carbon::parse($searchDate);
                $monthAbbr = $date->format('M'); // Get 'Jan', 'Feb', 'Apr', etc.

                // Filter where best_season (comma-separated) contains the month abbreviation
                // Using CONCAT for safer matching (prevents matching 'Jan' in 'January')
                $toursQuery->whereRaw('CONCAT(",", REPLACE(best_season, " ", ""), ",") LIKE ?', ["%," . $monthAbbr . ",%"]);
                // Explanation of whereRaw:
                // 1. REPLACE(best_season, " ", ""): Removes spaces (e.g., "Jan, Feb" -> "Jan,Feb")
                // 2. CONCAT(",", ..., ","): Adds commas at start/end (e.g., ",Jan,Feb,")
                // 3. LIKE "%,Apr,%": Matches if the month is present, surrounded by commas

            } catch (\Exception $e) {
                // Handle invalid date format if necessary, maybe ignore filter
                // Log::error("Invalid date format received: " . $searchDate);
            }
        }

        // Filter by Guests (checking against group_size)
        if ($selectedGuests && is_numeric($selectedGuests)) {
            $guestCount = (int) $selectedGuests;

            $toursQuery->where(function ($query) use ($guestCount) {
                // Case 1: group_size is a single number (e.g., "15") -> Max capacity
                $query->orWhere(function ($q) use ($guestCount) {
                    $q->where('group_size', 'REGEXP', '^[0-9]+$') // Check if it's purely numeric
                        ->where(DB::raw('CAST(group_size AS UNSIGNED)'), '>=', $guestCount);
                });

                // Case 2: group_size is a range (e.g., "8-12") -> Check max end of range
                $query->orWhere(function ($q) use ($guestCount) {
                    // Matches patterns like number-number
                    $q->where('group_size', 'REGEXP', '^[0-9]+\s*-\s*[0-9]+$')
                        // Extracts the number AFTER the hyphen and casts it
                        ->where(DB::raw('CAST(SUBSTRING_INDEX(group_size, "-", -1) AS UNSIGNED)'), '>=', $guestCount);
                });

                // Case 3: group_size is "X+" (e.g., "10+") -> Assume it can accommodate any number >= X
                $query->orWhere(function ($q) use ($guestCount) {
                    // Matches patterns like number+
                    $q->where('group_size', 'REGEXP', '^[0-9]+\s*\+$')
                        // Extracts the number BEFORE the plus and checks if guest count meets the minimum
                        ->where(DB::raw('CAST(SUBSTRING_INDEX(group_size, "+", 1) AS UNSIGNED)'), '<=', $guestCount);
                    // Alternatively, if "10+" means *always* available for groups, just include them:
                    // ->orWhere('group_size', 'REGEXP', '^[0-9]+\s*\+$'); // Always include "X+" if any guest count > 0 selected
                });

                // Add other potential formats if necessary (e.g., "Up to 10")
                // $query->orWhere(...)
            });
        }

        // Get paginated results
        $tours = $toursQuery->latest()->paginate(8); // Adjust pagination

        // --- Return the View with Data ---
        return view('tours-list', compact(
            'tours',            // The filtered list of tours
            'locations',        // Data for Destination dropdown (repopulation)
            // Pass back selected values for form repopulation
            'placeName',
            'searchDate',
            'selectedGuests'
        ));
    }


    /**
     * Display the specified resource (tour details).
     */
    public function show($slug) // Uses route model binding implicitly if configured
    {
        // Find tour by slug, eager load relations
        $tour = Tour::with(['images', 'itineraryDays', 'places'])
            ->where('slug', $slug)
            ->firstOrFail(); // Fails if not found

        // Example: Get related tours (e.g., in the same primary place or type) - Improve this logic
        $relatedTours = Tour::with(['firstImage'])
            ->withCount('places')
            ->where('id', '!=', $tour->id)
            ->whereHas('places', function ($query) use ($tour) {
                $query->whereIn('name', $tour->places->pluck('name'));
            })
            ->take(4)
            ->get();


        return view('tour-detail', compact('tour', 'relatedTours'));
    }


    // --- STORE / EDIT / UPDATE / DESTROY methods remain largely the same ---
    // They already handle the 'places' array correctly based on your previous code.

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation stays the same...
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:tours,title',
            // ... other fields
            'price_adult' => 'required|numeric|min:0',
            // ... other fields
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'places' => 'nullable|array', // Array of city/place names
            'places.*' => 'nullable|string|max:255' // Each place name
        ]);

        $tourData = collect($validatedData)->except(['images', 'places'])->toArray();
        $tourData['slug'] = Str::slug($validatedData['title']);

        // Handle potential slug collisions
        $originalSlug = $tourData['slug'];
        $count = 1;
        while (Tour::where('slug', $tourData['slug'])->exists()) {
            $tourData['slug'] = $originalSlug . '-' . $count++;
        }

        $tour = Tour::create($tourData);

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('images/tours', $filename, 'public');
                $tour->images()->create(['image' => 'storage/' . $path]); // Assumes TourImage model setup
            }
        }

        // Handle Places (Cities)
        if (!empty($validatedData['places'])) {
            foreach ($validatedData['places'] as $placeName) {
                $trimmedName = trim($placeName);
                if (!empty($trimmedName)) {
                    // Creates a new Place record associated with this Tour
                    $tour->places()->create(['name' => $trimmedName]); // Assumes Place model setup
                }
            }
        }

        // Add itineraryDays logic here if needed

        return redirect()->route('tours.show', $tour->slug)
            ->with('success', 'Tour created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $tour = Tour::with(['images', 'places', 'itineraryDays']) // Eager load places for the form
            ->where('slug', $slug)
            ->firstOrFail();

        return view('admin.tours.edit', compact('tour')); // Ensure this view exists
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();

        // Validation stays the same...
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('tours')->ignore($tour->id)],
            // ... other fields
            'price_adult' => 'required|numeric|min:0',
            // ... other fields
            'places' => 'nullable|array',
            'places.*' => 'nullable|string|max:255'
            // Add image update validation if needed
        ]);

        $tourData = collect($validatedData)->except(['places'])->toArray();

        // Update slug only if title changed
        if ($request->input('title') !== $tour->title) {
            $tourData['slug'] = Str::slug($validatedData['title']);
            $originalSlug = $tourData['slug'];
            $count = 1;
            while (Tour::where('slug', $tourData['slug'])->where('id', '!=', $tour->id)->exists()) {
                $tourData['slug'] = $originalSlug . '-' . $count++;
            }
        } else {
            unset($tourData['slug']); // Don't update slug if title hasn't changed
        }

        $tour->update($tourData);

        // Sync Places (Efficiently updates the relationship)
        $newPlaces = [];
        if (!empty($validatedData['places'])) {
            foreach ($validatedData['places'] as $placeName) {
                $trimmedName = trim($placeName);
                if (!empty($trimmedName)) {
                    // Prepare data for createMany - doesn't save yet
                    $newPlaces[] = ['name' => $trimmedName];
                }
            }
        }
        $tour->places()->delete(); // Delete old places associated with this tour
        if (!empty($newPlaces)) {
            $tour->places()->createMany($newPlaces); // Create all new places at once
        }


        // Add logic for image updates (upload new, delete selected) if needed

        return redirect()->route('tours.show', $tour->fresh()->slug) // Use fresh() in case slug changed
            ->with('success', 'Tour updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();

        // Optional: Add manual file deletion logic if needed
        // Storage::disk('public')->delete(...);

        $tour->delete(); // This should cascade delete related places, images due to onDelete('cascade')

        return redirect()->route('tours.index') // Redirect to the main tours list
            ->with('success', 'Tour deleted successfully!');
    }
    public function byPlace($slug)
    {
        $place = Place::where('slug', $slug)->firstOrFail();

        $tours = $place->tours()
            ->with(['firstImage', 'places'])
            ->latest()
            ->paginate(8);

        return view('tours-list', [
            'tours' => $tours,
            'placeName' => $place->name,
            'query' => null,
            'locations' => Place::pluck('name')->unique(), // Pour le dropdown
            'searchDate' => null,
            'selectedGuests' => null
        ]);
    }

}
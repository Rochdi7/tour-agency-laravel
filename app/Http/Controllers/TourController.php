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
use App\Models\Activity;
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
        $searchDate = $request->input('searchDate');
        $selectedGuests = $request->input('guests');

        // --- Dropdown Locations ---
        $locations = Place::query()
            ->where(function ($query) {
                $query->whereHas('tours')->orWhereHas('activities');
            })
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->pluck('name')
            ->unique();

        // --- Build Tour Query for Search ---
        $toursQuery = Tour::query()
            ->with(['firstImage', 'places'])
            ->withCount('places');

        if ($placeName) {
            $toursQuery->whereHas('places', function ($q) use ($placeName) {
                $q->where('name', $placeName);
            });
        }

        if ($searchDate) {
            try {
                $date = Carbon::parse($searchDate);
                $monthAbbr = $date->format('M');
                $toursQuery->whereRaw('CONCAT(",", REPLACE(best_season, " ", ""), ",") LIKE ?', ["%," . $monthAbbr . ",%"]);
            } catch (\Exception $e) {
                // Handle invalid date if needed
            }
        }

        if ($selectedGuests && is_numeric($selectedGuests)) {
            $guestCount = (int) $selectedGuests;
            $toursQuery->where(function ($query) use ($guestCount) {
                $query->orWhere(function ($q) use ($guestCount) {
                    $q->where('group_size', 'REGEXP', '^[0-9]+$')
                        ->where(DB::raw('CAST(group_size AS UNSIGNED)'), '>=', $guestCount);
                });
                $query->orWhere(function ($q) use ($guestCount) {
                    $q->where('group_size', 'REGEXP', '^[0-9]+\s*-\s*[0-9]+$')
                        ->where(DB::raw('CAST(SUBSTRING_INDEX(group_size, "-", -1) AS UNSIGNED)'), '>=', $guestCount);
                });
                $query->orWhere(function ($q) use ($guestCount) {
                    $q->where('group_size', 'REGEXP', '^[0-9]+\s*\+$')
                        ->where(DB::raw('CAST(SUBSTRING_INDEX(group_size, "+", 1) AS UNSIGNED)'), '<=', $guestCount);
                });
            });
        }

        $tours = $toursQuery->latest()->paginate(8); // Paginated tour list

        // --- Top Tours (Popular First) for Homepage Slider ---
        $popularTours = Tour::where('is_popular', true)
            ->with(['firstImage', 'places'])
            ->get();

        $nonPopularTours = Tour::where('is_popular', false)
            ->whereNotIn('id', $popularTours->pluck('id'))
            ->with(['firstImage', 'places'])
            ->get();

        $topTours = $popularTours->concat($nonPopularTours); // ✅ Popular first, then others

        // --- Return View ---
        return view('tours-list', compact(
            'tours',
            'locations',
            'placeName',
            'searchDate',
            'selectedGuests',
            'topTours' // ✅ Used in your slider section
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
    public function showMultiDay()
    {
        $types = ['Garden Tours', 'Art Tours', 'Classical Tours'];

        $tours = Tour::whereIn('tour_type', $types)
            ->with(['firstImage', 'places'])
            ->paginate(12);

        // Activities will be completely removed
        $activities = [];

        return view('type-filter', [
            'tours' => $tours,
            'activities' => $activities,
            'type' => 'Multi-Day Tours'
        ]);
    }



    public function showOneDay()
    {
        // Tour types for One-Day
        $types = ['City Tours', 'Day Trips', 'Local Experiences', 'Outdoor Activities'];

        // Fetch data
        $tours = Tour::whereIn('tour_type', $types)->with(['firstImage', 'places'])->paginate(12);
        $activities = Activity::whereIn('tour_type', $types)->with(['images', 'category'])->paginate(12);

        // Return the view
        return view('type-filter', [
            'tours' => $tours,
            'activities' => $activities,
            'type' => 'One-Day Tours'
        ]);
    }



    public function showByType($type)
    {
        $tours = Tour::where('tour_type', $type)->with(['firstImage', 'places'])->paginate(12);
        $activities = Activity::where('tour_type', $type)->with(['images', 'category'])->paginate(12);

        return view('type-filter', [
            'tours' => $tours,
            'activities' => $activities,
            'type' => $type
        ]);
    }
}
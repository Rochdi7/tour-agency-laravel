<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityImage;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'activity_category_id' => 'nullable|exists:activity_categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $activityData = $request->except('images');
        $activityData['slug'] = Str::slug($request->title);

        $activity = Activity::create($activityData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/images/activities'), $filename);

                ActivityImage::create([
                    'activity_id' => $activity->id,
                    'image' => 'storage/images/activities/' . $filename,
                ]);
            }
        }

        return redirect()->route('activity-categories')->with('success', 'Activity created successfully!');
    }

    public function listCategories()
    {
        $activityCategories = ActivityCategory::query() // Querying the ActivityCategory model
            ->withCount('activities')
            ->orderBy('name', 'asc')
            ->paginate(9);
    
        // Passing the variable to the view
        return view('activity-categories', compact('activityCategories'));
    }

    public function showByCategory($category_slug)
    {
        // Find the category by its slug or fail (404)
        $category = ActivityCategory::where('slug', $category_slug)->firstOrFail();

        // Fetch paginated activities belonging to this category
        // Eager load images for efficiency in the view
        $activities = $category->activities() // Use the relationship defined in ActivityCategory model
                              ->with('images')
                              ->latest() // Order by newest first, or change as needed
                              ->paginate(9); // Adjust pagination count (e.g., 9 per page)

        // Pass the category and its activities to the new view
        return view('activities-by-category', compact('category', 'activities'));
    }

    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $activitiesQuery = Activity::query()
            ->with(['images', 'category'])
            ->latest();

        if ($categorySlug) {
            $activitiesQuery->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $activities = $activitiesQuery->paginate(12);
        $category = $categorySlug ? ActivityCategory::where('slug', $categorySlug)->first() : null;

        return view('activity-categories', compact('activities', 'category'));  
    }

// In app/Http/Controllers/ActivityController.php
public function show($slug)
{
    // Eager load images, category, AND itineraryDays
    $activity = Activity::with(['images', 'category', 'itineraryDays']) // <-- Make sure 'itineraryDays' is here
                        ->where('slug', $slug)
                        ->firstOrFail();

    // Fetch related activities (example logic)
    $relatedActivities = Activity::with('images')
        ->where('id', '!=', $activity->id)
        ->when($activity->activity_category_id, function ($query) use ($activity) {
            $query->where('activity_category_id', $activity->activity_category_id);
        })
        ->latest()
        ->take(3)
        ->get();

    return view('activity-detail', compact('activity', 'relatedActivities'));
}
    }

<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Place;
use App\Models\ActivityCategory;
use Illuminate\Http\Request; // Although not used in this specific method, it's standard practice
use Illuminate\View\View; // For return type hinting

class HomepageController extends Controller
{
    /**
     * Display the homepage with necessary data.
     *
     * Gathers latest posts, top tours, featured activities,
     * and filter options (locations, seasons, group sizes)
     * to pass to the home view.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // --- Fetch Content ---
        $latestPosts = Blog::latest()->take(3)->get();

        // Eager load necessary relationships for tours
        $topTours = Tour::with([
                            'firstImage', // Assuming 'firstImage' is a defined relationship for the primary image
                            'places' // Assuming 'places' is a relationship linking tours to locations
                          ])
                          ->latest()
                          ->take(4)
                          ->get();

        // Eager load images for activities
        $featuredActivities = Activity::with('images') // Assuming 'images' is the relationship for activity images
                                      ->latest()
                                      ->take(6)
                                      ->get();

        // --- Prepare Filter Data ---

        // 🗺️ Merge places and activity categories for Location filter
        // Ensure 'name' column exists and filter out null/empty values
        $placeNames = Place::whereNotNull('name')->where('name', '!=', '')->pluck('name');
        $categoryNames = ActivityCategory::whereNotNull('name')->where('name', '!=', '')->pluck('name');

        // Combine, ensure uniqueness, sort alphabetically, and reset keys
        $locations = collect($placeNames)
                        ->merge($categoryNames)
                        ->unique()
                        ->sort()
                        ->values(); // values() resets keys to be sequential (0, 1, 2...)

        // 📅 Merge seasons from both tours and activities for Season filter
        // Ensure 'best_season' exists and filter out null/empty values
        $tourSeasons = Tour::whereNotNull('best_season')->where('best_season', '!=', '')->pluck('best_season');
        $activitySeasons = Activity::whereNotNull('best_season')->where('best_season', '!=', '')->pluck('best_season');

        // Combine, filter out any remaining blanks after pluck, ensure uniqueness, sort, reset keys
        $seasons = $tourSeasons
                      ->merge($activitySeasons)
                      ->filter() // Removes null/empty/false values
                      ->unique()
                      ->sort()
                      ->values();

        // 👥 Merge group sizes from both tables for Group Size filter (optional logic)
        // Ensure 'group_size' exists and filter out null/empty values
        $tourGroups = Tour::whereNotNull('group_size')->where('group_size', '!=', '')->pluck('group_size');
        $activityGroups = Activity::whereNotNull('group_size')->where('group_size', '!=', '')->pluck('group_size');

        // Combine, filter, ensure uniqueness, sort, reset keys
        $groupSizes = $tourGroups
                        ->merge($activityGroups)
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values();


        // --- Return View ---
        // Pass all the collected data to the 'home' view
        return view('home', compact(
            'latestPosts',
            'topTours',
            'featuredActivities',
            'locations',
            'seasons',
            'groupSizes'
        ));
    }
}
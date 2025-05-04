<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Blog;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $place = $request->input('place');
        $guests = $request->input('guests');

        $tours = collect();
        $activities = collect();
        $blogs = collect();

        // Keyword search (title/overview-based)
        if ($query) {
            $tours = Tour::where('title', 'like', '%' . $query . '%')
                ->orWhere('overview', 'like', '%' . $query . '%')
                ->get();

            $activities = Activity::where('title', 'like', '%' . $query . '%')
                ->orWhere('overview', 'like', '%' . $query . '%')
                ->get();

            $blogs = Blog::where('title', 'like', '%' . $query . '%')
                ->orWhere('summary', 'like', '%' . $query . '%')
                ->orWhere('content', 'like', '%' . $query . '%')
                ->get();
        }

        // Exact match search for destination + guests
        if ($place && $guests) {
            // Override tours to only return strict matches
            $tours = Tour::whereHas('places', function ($q) use ($place) {
                $q->where('name', '=', $place);
            })->where('group_size', '=', $guests)->get();

            // Override activities to match either place or category
            $activities = Activity::where(function ($query) use ($place) {
                $query->whereHas('places', function ($q) use ($place) {
                    $q->where('name', '=', $place);
                })->orWhereHas('category', function ($q) use ($place) {
                    $q->where('name', '=', $place);
                });
            })->where('group_size', '=', $guests)->get();
        }

        return view('search.results', compact('query', 'tours', 'activities', 'blogs'));
    }
}

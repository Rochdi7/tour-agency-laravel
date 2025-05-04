<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Blog;

class SearchBarController extends Controller
{
    public function index(Request $request)
    {
        $place = $request->input('place');
        $guests = $request->input('guests');

        $tours = collect();
        $activities = collect();

        if (!$place || !$guests) {
            return view('search-bar', [
                'tours' => $tours,
                'activities' => $activities,
                'filters' => $request->all(),
            ]);
        }

        // Search in Tours (place match + exact group size)
        $tours = Tour::whereHas('places', function ($q) use ($place) {
            $q->where('name', '=', $place);
        })->where('group_size', '=', $guests)->get();

        // Search in Activities (place or category match + exact group size)
        $activities = Activity::where(function ($query) use ($place) {
            $query->whereHas('places', function ($q) use ($place) {
                $q->where('name', '=', $place);
            })->orWhereHas('category', function ($q) use ($place) {
                $q->where('name', '=', $place);
            });
        })->where('group_size', '=', $guests)->get();

        return view('search-bar', [
            'tours' => $tours,
            'activities' => $activities,
            'filters' => $request->all(),
        ]);
    }
}

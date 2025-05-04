<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Tour;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function index()
    {
        $latestPosts = Cache::remember('latest_posts', 60, function () {
            return Blog::latest()->take(3)->get();
        });
    
        $topTours = Cache::remember('top_tours', 60, function () {
            return Tour::with(['firstImage', 'places'])
                       ->withCount('places')
                       ->latest()
                       ->take(4)
                       ->get();
        });
    
        return view('home', compact('latestPosts', 'topTours'));
    }

    
    

}

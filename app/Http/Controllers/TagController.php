<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog; // Import Blog model
use App\Models\Category; // Import Category model
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display blog posts filtered by a specific tag.
     *
     * @param string $slug The slug of the tag to filter by.
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // 1. Find the specific tag by its URL-friendly 'slug', or show a 404 error if not found.
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // 2. Get all blog posts THAT HAVE this specific tag associated.
        //    - Eager load 'user' and 'category' to avoid extra database queries in the view.
        //    - Order them by the newest first.
        //    - Paginate the results (show 10 posts per page).
        $posts = $tag->blogs() // Access the relationship defined in Tag.php
                     ->with(['user', 'category']) // Load related user and category data
                     ->latest() // Order by created_at descending
                     ->paginate(10); // Get paginated results

        // 3. Get data needed for the sidebar (same as BlogController index/show)
        $recentBlogs = Blog::latest()->take(5)->get();
        $categories = Category::withCount('blogs')->orderBy('name')->get();
        $tags = Tag::all(); // Get ALL tags for the sidebar tag list

        // 4. Return the 'blog' view (which is often the same view used for the main blog index).
        //    Pass all the necessary data to the view.
        return view('blog', compact(
            'posts',        // The filtered & paginated posts for this tag
            'recentBlogs',  // For sidebar
            'categories',   // For sidebar
            'tags',         // All tags for sidebar
            'tag'           // Pass the current tag itself (e.g., to display "Posts tagged with: X")
        ));
    }
}
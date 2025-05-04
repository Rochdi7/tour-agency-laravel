<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment; // Import Comment model if used directly
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // ... (getSidebarData method remains the same) ...
    private function getSidebarData()
    {
        $recentBlogs = Blog::latest()->take(5)->get();
        $categories = Category::withCount('blogs')
                              ->having('blogs_count', '>', 0)
                              ->orderBy('name', 'asc')
                              ->get();
        $tags = Tag::orderBy('name', 'asc')->get();
        return compact('recentBlogs', 'categories', 'tags');
    }

    // ... (index and search methods remain the same, using 'blog' view) ...
    public function index()
    {
        $posts = Blog::with(['user', 'category', 'tags']) // Eager loads Blog's author (User)
                     ->latest()
                     ->paginate(10);
        $sidebarData = $this->getSidebarData();
        return view('blog', compact('posts'), $sidebarData); // Uses 'blog.blade.php'
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return redirect()->route('blog.index');
        }
        $posts = Blog::with(['user', 'category', 'tags']) // Eager loads Blog's author (User)
                     ->where(function ($q) use ($query) {
                         $q->where('title', 'LIKE', "%{$query}%")
                           ->orWhere('content', 'LIKE', "%{$query}%")
                           ->orWhere('summary', 'LIKE', "%{$query}%");
                     })
                     ->latest()
                     ->paginate(10)
                     ->appends(['query' => $query]);
        $sidebarData = $this->getSidebarData();
        return view('blog', compact('posts', 'query'), $sidebarData); // Uses 'blog.blade.php'
    }


    /**
     * Display the specified blog post (details page).
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Eager load Blog's author (user) and its comments (but not the comment's user)
        $post = Blog::with([
                        'category',
                        'tags',
                        'user',     // User who wrote the blog post
                        'comments'  // Comments belonging to the blog post
                    ])
                 ->where('slug', $slug)
                 ->firstOrFail();

        $previousPost = Blog::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Blog::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        $relatedPosts = Blog::where('id', '!=', $post->id)
                           ->where('category_id', $post->category_id)
                           ->latest()
                           ->take(3)
                           ->get();

        $sidebarData = $this->getSidebarData();

        // Uses 'blog-details.blade.php'
        return view('blog-details', compact(
            'post',
            'previousPost',
            'nextPost',
            'relatedPosts'
        ), $sidebarData);
    }

    /**
     * Store a newly created blog post in storage.
     * Assigns the logged-in user as the author of the post.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Blog $blog) // <-- Accept Blog model directly
    {
        $request->validate([
            'content' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // No need for Blog::findOrFail($blogId) anymore, $blog is already loaded.

        Comment::create([
            'blog_id' => $blog->id, // Use the injected $blog object's ID
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            // Add other fields if needed (e.g., 'is_approved' => false)
        ]);

        return redirect()->back()->with('success', 'Your comment has been submitted successfully!'); // Changed message slightly
    }

    // ... (Optional showByCategory / showByTag methods) ...

}
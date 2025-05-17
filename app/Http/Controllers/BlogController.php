<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Get Sidebar Data for Blog Pages.
     */
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

    /**
     * Display the Blog Index Page.
     */
    public function index()
    {
        $posts = Blog::with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(10);
            
        $sidebarData = $this->getSidebarData();
        
        return view('blog', compact('posts'), $sidebarData);
    }

    /**
     * Search Blog Posts.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return redirect()->route('blog.index');
        }

        $posts = Blog::with(['user', 'category', 'tags'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhere('summary', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['query' => $query]);
        
        $sidebarData = $this->getSidebarData();
        
        return view('blog', compact('posts', 'query'), $sidebarData);
    }

    /**
     * Display a Specific Blog Post with Comments.
     */
    public function show($slug)
    {
        $post = Blog::with([
            'category',
            'tags',
            'user',
            'comments.replies'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        $previousPost = Blog::where('id', '<', $post->id)
            ->orderBy('id', 'desc')
            ->first();
        $nextPost = Blog::where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        $relatedPosts = Blog::where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest()
            ->take(3)
            ->get();

        $sidebarData = $this->getSidebarData();

        return view('blog-details', compact(
            'post',
            'previousPost',
            'nextPost',
            'relatedPosts'
        ), $sidebarData);
    }

    /**
     * Store a New Comment.
     */
    public function storeComment(Request $request, $blogId)
    {
        $request->validate([
            'content' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Comment::create([
            'blog_id' => $blogId,
            'parent_id' => null, // Root comment
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Your comment has been added successfully!');
    }

    /**
     * Store a Reply to a Comment.
     */
    public function replyToComment(Request $request, $commentId)
    {
        $request->validate([
            'content' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $parentComment = Comment::findOrFail($commentId);

        Comment::create([
            'blog_id' => $parentComment->blog_id,
            'parent_id' => $parentComment->id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Reply added successfully.');
    }
}

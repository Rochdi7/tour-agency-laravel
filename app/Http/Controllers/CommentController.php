<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $blogId)
    {
        $request->validate([
            'content' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $blog = Blog::findOrFail($blogId);

        Comment::create([
            'blog_id' => $blog->id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Your comment has been posted!');
    }
}

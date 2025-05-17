<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Comment;


class CommentController extends Controller
{
    public function show($id)
    {
        // Get all parent comments and their nested replies
        $comments = Comment::where('blog_id', $id)
            ->whereNull('parent_id')
            ->with('replies')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('blog.show', compact('comments'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
            'name' => 'required',
            'email' => 'required|email'
        ]);

        Comment::create([
            'parent_id' => $request->parent_id,
            'blog_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'summary',
        'content',
        'quote',
        'quote_author',
        'written_by',
        'featured_image',
        'featured_image_alt',
        'featured_image_caption',
        'featured_image_description',
        'category_id'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }
    public function comments() // Comments for this blog post
    {
        return $this->hasMany(Comment::class); // Assuming Comment model is App\Models\Comment
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

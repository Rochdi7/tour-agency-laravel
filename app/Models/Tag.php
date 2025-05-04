<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Added standard factory trait
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import the Str class

class Tag extends Model
{
    use HasFactory; // Use the factory trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        // 'slug' is NOT fillable because it's generated automatically below
        ];

    /**
     * Get the blogs associated with this tag.
     * Defines the many-to-many relationship.
     */
    public function blogs()
    {
        // Links Tag model to Blog model through the 'blog_tag' pivot table
        return $this->belongsToMany(Blog::class, 'blog_tag');
    }

    /**
     * Boot the model.
     * This method runs automatically when the model is used.
     */
    protected static function boot()
    {
        parent::boot();

        // Listen for the 'creating' event (before a new tag is saved)
        static::creating(function ($tag) {
            // Automatically create the 'slug' based on the tag's 'name'
            // Example: "Laravel Tips" becomes "laravel-tips"
            if (empty($tag->slug)) { // Only generate if slug is not already set
                 $tag->slug = Str::slug($tag->name);
            }
        });

         // Optional: Add this if you ever UPDATE a tag's name and want the slug to update too
        // static::updating(function ($tag) {
        //     if ($tag->isDirty('name')) { // Check if the name field specifically is being changed
        //         $tag->slug = Str::slug($tag->name);
        //     }
        // });
    }

    /**
      * Optional: If you want route model binding to work directly with slugs
      * without specifying {tag:slug} in the route file.
      * Keep this commented out if you prefer specifying in the route file.
      */
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
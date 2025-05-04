<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Import HasMany relation
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Import HasFactory if you use factories
use Illuminate\Support\Str; // <-- Import Str for slug generation

class ActivityCategory extends Model
{
    // Add HasFactory if you use model factories
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ // <-- Add fillable attributes
        'name',
        'slug',
        'image_path',
        'description',
    ];

    /**
     * Get the activities belonging to this category.
     * Defines the one-to-many relationship.
     */
    public function activities(): HasMany // <-- DEFINE THE RELATIONSHIP METHOD
    {
        // Assumes the foreign key in the 'activities' table is 'activity_category_id'
        return $this->hasMany(Activity::class, 'activity_category_id');
    }

    /**
     * Automatically create/update slug when saving.
     * (Copied from previous definition - ensure it's present)
     */
    protected static function booted() // <-- ADD SLUG GENERATION BACK
    {
        static::saving(function ($category) {
            if (empty($category->slug) || $category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
                // Optional: Handle potential slug collisions if needed
                $originalSlug = $category->slug;
                $count = 1;
                // Ensure you check against the current model instance using static::
                while (static::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
                     $category->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }
}
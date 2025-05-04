<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\ActivityImage; // For the images relationship
use App\Models\ActivityCategory; // For the category relationship
use App\Models\ItineraryDay; // <-- IMPORT THE ITINERARY DAY MODEL
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Activity extends Model
{
    use HasFactory;
    public function places()
    {
        return $this->belongsToMany(Place::class, 'activity_place');
    }
    
    protected $fillable = [
        'activity_category_id',
        'title',
        'slug',
        'subtitle',
        'overview',
        'itinerary',
        'includes',
        'excludes',
        'faq',
        'transportation',
        'accommodation',
        'departure',
        'altitude',
        'best_season',
        'tour_type',
        'group_size',
        'min_age',
        'max_age',
        'price_adult',
        'price_child',
        'duration_days',
        'old_price_adult',
        'old_price_child',
        'discount',
        'discount_percentage',
    ];

    // Relationship to Images
    public function images()
    {
        return $this->hasMany(\App\Models\ActivityImage::class);
    }


    // Relationship to Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class, 'activity_category_id');
    }

    /**
     * Get all of the itinerary days for the Activity.
     * Defines the polymorphic relationship.
     * <<< --- ADD THIS METHOD --- >>>
     */
    public function itineraryDays()
    {
        return $this->morphMany(\App\Models\ItineraryDay::class, 'itineraryable')->orderBy('day_number');
    }



    // Slug generation logic
    protected static function booted()
    {
        static::saving(function ($activity) {
            if (empty($activity->slug) || $activity->isDirty('title')) {
                $activity->slug = Str::slug($activity->title);
                // Optional: Handle potential slug collisions
                $originalSlug = $activity->slug;
                $count = 1;
                while (static::where('slug', $activity->slug)->where('id', '!=', $activity->id)->exists()) {
                    $activity->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }
}
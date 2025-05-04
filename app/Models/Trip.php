<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'overview', 'itinerary', 'includes', 'excludes', 'faq',
        'transportation', 'accommodation', 'departure', 'altitude', 'best_season',
        'tour_type', 'group_size', 'min_age', 'max_age',
        'price_adult', 'price_child', 'duration_days'
    ];

    protected static function booted()
    {
        static::saving(function ($trip) {
            if (empty($trip->slug) || $trip->isDirty('title')) {
                $trip->slug = Str::slug($trip->title);
                $originalSlug = $trip->slug;
                $count = 1;
                while (static::where('slug', $trip->slug)->where('id', '!=', $trip->id)->exists()) {
                    $trip->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    public function itineraryDays()
    {
        return $this->morphMany(\App\Models\ItineraryDay::class, 'itineraryable')->orderBy('day_number');
    }
    
    public function images()
    {
        return $this->hasMany(\App\Models\TripImage::class);
    }
    
}

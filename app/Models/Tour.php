<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TourImage;
use App\Models\ItineraryDay;
use App\Models\Place;
use Illuminate\Support\Str;

class Tour extends Model
{
    // use HasFactory; // Uncomment if you use factories

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'overview',
        'includes',         // <<< CORRECTED
        'excludes',
        'subtitle',         // <<< CORRECTED
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
        'old_price_adult',
        'old_price_child',
        'discount',
        'duration_days',

        // 'itinerary', // Decide if needed
    ];

    /**
     * The attributes that should be cast.
     * Optional but recommended for clarity, especially if DB column might be nullable.
     */
    protected $casts = [
        'includes' => 'string',
        'excludes' => 'string',
        'faq' => 'string', // Cast FAQ too if it's text/longtext
        'price_adult' => 'decimal:2', // Example cast for prices
        'price_child' => 'decimal:2', // Example cast for prices
        'duration_days' => 'integer',
        'min_age' => 'integer',
        'max_age' => 'integer',
    ];

    // ... rest of your model code (relationships, booted method, etc.) ...

    public function images()
    {
        return $this->hasMany(\App\Models\TourImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(\App\Models\TourImage::class)->oldestOfMany();
    }



    // Function definition misplaced - should likely be in Controller or a Service
    /*
    public function listPlaces()
    {
        $placesData = Place::withCount('tours')->paginate(12);
        return view('destinations', compact('placesData'));
    }
    */

    public function itineraryDays()
    {
        return $this->morphMany(\App\Models\ItineraryDay::class, 'itineraryable')->orderBy('day_number');
    }

    public function accommodations()
    {
        return $this->hasMany(TourAccommodation::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'place_tour');
    }

    protected static function booted()
    {
        static::creating(function ($tour) {
            if (empty($tour->slug) && !empty($tour->title)) {
                $tour->slug = Str::slug($tour->title);
                // Add collision check here if needed during creation too
            }
        });
    }
}
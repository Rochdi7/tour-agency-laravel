<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import this

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image_path', // <-- ADDED
        'description',
    ];

    /**
     * The tours that include this place.
     * Defines the Many-to-Many relationship.
     */
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'place_tour');
    }
    protected static function booted()
    {
        static::saving(function ($place) {
            if (empty($place->slug)) {
                $place->slug = \Str::slug($place->name);
            }
        });
    }
    public function activities()
{
    return $this->belongsToMany(Activity::class, 'activity_place');
}
    

    

    // REMOVE any belongsTo(Tour::class) relationship if present
}
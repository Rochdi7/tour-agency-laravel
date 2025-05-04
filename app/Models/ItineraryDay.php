<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItineraryDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'itineraryable_id',
        'itineraryable_type',
        'day_number',
        'title',
        'description',
    ];

    /**
     * Get the parent model (Tour, Trip, or Activity).
     */
    public function itineraryable()
    {
        return $this->morphTo();
    }
}

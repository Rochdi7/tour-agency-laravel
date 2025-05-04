<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAccommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'city',
        'hotel_name',
        'description',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

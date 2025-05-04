<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripImage extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id', 'image_path', 'caption'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}

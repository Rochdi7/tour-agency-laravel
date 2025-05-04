<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityImage extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'image', 'caption', 'alt', 'description'];

    public function activity()
    {
        return $this->belongsTo(\App\Models\Activity::class);
    }
}

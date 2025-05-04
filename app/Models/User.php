<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; // ✅ Add this

class User extends Authenticatable implements FilamentUser // ✅ Add interface
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ This is required to access Filament panels
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
}

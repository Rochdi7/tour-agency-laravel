<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; 

class User extends Authenticatable implements FilamentUser 
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : null;
    }
    public function getIsAdminAttribute()
{
    return $this->role === 'admin' || $this->email === 'admin@example.com';
}

}

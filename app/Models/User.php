<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; 


    protected $fillable = [
        'name', 'email', 'password',
        'role', 'avatar', 'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relations ──────────────────────────────
    public function recipes()
    {
        return $this->hasMany(Recipe::class);      // ← NOUVEAU
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);      // ← NOUVEAU
    }

    // ── Helper ─────────────────────────────────
    public function isAdmin(): bool                // ← NOUVEAU
    {
        return $this->role === 'admin';
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instrument',
        'bio',
        'education_level',
        'city',
        'age',
        'gender',
        'avatar_url',
        'cover_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->attributes['avatar_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=random';
    }

    public function getCoverUrlAttribute()
    {
        return $this->attributes['cover_url'] ?? null;
    }
} 
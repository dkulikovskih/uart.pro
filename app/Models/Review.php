<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'musician_id',
        'rating',
        'comment',
        'response',
        'photos',
        'is_moderated',
        'moderated_at'
    ];

    protected $casts = [
        'photos' => 'array',
        'is_moderated' => 'boolean',
        'moderated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function musician()
    {
        return $this->belongsTo(User::class, 'musician_id');
    }

    public function reactions()
    {
        return $this->hasMany(ReviewReaction::class);
    }

    public function likes()
    {
        return $this->reactions()->where('type', 'like');
    }

    public function dislikes()
    {
        return $this->reactions()->where('type', 'dislike');
    }

    public function hasUserReacted(User $user)
    {
        return $this->reactions()->where('user_id', $user->id)->exists();
    }

    public function getUserReaction(User $user)
    {
        return $this->reactions()->where('user_id', $user->id)->first();
    }
}

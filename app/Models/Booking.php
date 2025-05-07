<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'musician_id',
        'start_time',
        'end_time',
        'event_type',
        'description',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function musician()
    {
        return $this->belongsTo(User::class, 'musician_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

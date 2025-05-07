<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'avatar',
        'instrument',
        'education_level',
        'gender',
        'birth_date',
        'city',
        'bio',
        'instruments',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'instruments' => 'array',
        'birth_date' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function musicianBookings()
    {
        return $this->hasMany(Booking::class, 'musician_id');
    }

    public function isMusician(): bool
    {
        return $this->role === 'musician';
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return asset('images/default-avatar.png');
        }
        
        // Если аватар - это URL (начинается с http)
        if (str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }
        
        // Если аватар хранится локально
        return asset('storage/' . $this->avatar);
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function scopeMusicians($query)
    {
        return $query->where('role', 'musician');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['instrument'] ?? false, function ($query, $instrument) {
            $query->where('instruments', 'like', '%' . $instrument . '%');
        })
        ->when($filters['education'] ?? false, function ($query, $education) {
            $query->where('education_level', $education);
        })
        ->when($filters['gender'] ?? false, function ($query, $gender) {
            $query->where('gender', $gender);
        })
        ->when($filters['city'] ?? false, function ($query, $city) {
            $query->where('city', 'like', '%' . $city . '%');
        })
        ->when($filters['min_age'] ?? false, function ($query, $minAge) {
            $query->whereDate('birth_date', '<=', now()->subYears($minAge));
        })
        ->when($filters['max_age'] ?? false, function ($query, $maxAge) {
            $query->whereDate('birth_date', '>=', now()->subYears($maxAge + 1));
        });
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('read', false);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'musician_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
}

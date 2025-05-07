<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'booking_id',
        'read'
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function getLink()
    {
        if ($this->type === 'new_message') {
            // Для уведомлений о сообщениях используем ID отправителя
            $message = Message::where('recipient_id', $this->user_id)
                            ->latest()
                            ->first();
            return $message ? route('chat.index', $message->user_id) : route('dashboard');
        }

        return match($this->type) {
            'booking_confirmed', 'booking_cancelled', 'new_booking' => route('bookings.show', $this->booking_id),
            default => route('dashboard')
        };
    }

    public function getBackgroundClass()
    {
        $baseClass = $this->read ? 'bg-opacity-50' : 'bg-opacity-80';
        
        return match($this->type) {
            'booking_confirmed' => "bg-green-600 {$baseClass}",
            'booking_cancelled' => "bg-red-600 {$baseClass}",
            'new_booking' => "bg-yellow-600 {$baseClass}",
            'new_message' => "bg-blue-600 {$baseClass}",
            default => "bg-gray-600 {$baseClass}"
        };
    }
}

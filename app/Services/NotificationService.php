<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    private $instanceId;
    private $secretKey;

    public function __construct()
    {
        $this->instanceId = '9e035686-477a-4d1c-bce8-78c3206216bb';
        $this->secretKey = '83A56961DC9F2C069BF9470C8EC74D699E4213E707ECF2E4438F3A4D86D486F6';
    }

    public function sendNewMessageNotification(Message $message)
    {
        $booking = $message->booking;
        $sender = $message->user;
        $recipient = $booking->user_id === $sender->id ? $booking->musician : $booking->user;

        $this->sendToUser($recipient->id, [
            'title' => 'Новое сообщение',
            'body' => "{$sender->name}: {$message->content}"
        ]);
    }

    public function sendBookingStatusNotification(Booking $booking)
    {
        $statusText = match($booking->status) {
            'pending' => 'ожидает подтверждения',
            'confirmed' => 'подтвержден',
            'completed' => 'завершен',
            'cancelled' => 'отменен',
            default => 'обновлен'
        };

        // Уведомление заказчику
        $this->sendToUser($booking->user_id, [
            'title' => 'Статус заказа',
            'body' => "Ваш заказ #{$booking->id} {$statusText}",
            'type' => 'booking_' . $booking->status,
            'booking_id' => $booking->id
        ]);

        // Уведомление музыканту
        if ($booking->musician_id) {
            $this->sendToUser($booking->musician_id, [
                'title' => 'Статус заказа',
                'body' => "Заказ #{$booking->id} {$statusText}",
                'type' => 'booking_' . $booking->status,
                'booking_id' => $booking->id
            ]);
        }
    }

    public function sendNewBookingNotification(Booking $booking)
    {
        if ($booking->musician_id) {
            $this->sendToUser($booking->musician_id, [
                'title' => 'Новый заказ',
                'body' => "У вас новый заказ #{$booking->id} от {$booking->user->name}",
                'type' => 'new_booking',
                'booking_id' => $booking->id
            ]);
        }
    }

    private function sendToUser(int $userId, array $notification)
    {
        return \App\Models\Notification::create([
            'user_id' => $userId,
            'type' => $notification['type'] ?? 'system',
            'message' => $notification['body'],
            'booking_id' => $notification['booking_id'] ?? null,
            'read' => false
        ]);
    }
} 
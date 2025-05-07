<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Booking;
use App\Models\Message;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Booking $booking)
    {
        $messages = $booking->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = $booking->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $message->load('user');

        // Отправляем уведомление о новом сообщении
        $this->notificationService->sendNewMessageNotification($message);

        broadcast(new NewMessage($message))->toOthers();

        return response()->json($message);
    }
}

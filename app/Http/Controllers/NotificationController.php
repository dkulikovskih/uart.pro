<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['read' => true]);
        return back();
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['read' => true]);
        }
        return back();
    }
}

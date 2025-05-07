<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(User $user)
    {
        $messages = Message::where(function($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('recipient_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('recipient_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return view('chat.index', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'recipient_id' => $user->id,
            'content' => $request->content,
        ]);

        // Создаем уведомление для получателя
        Notification::create([
            'user_id' => $user->id,
            'type' => 'new_message',
            'message' => Auth::user()->name . ' отправил вам сообщение',
            'read' => false,
        ]);

        return back();
    }
} 
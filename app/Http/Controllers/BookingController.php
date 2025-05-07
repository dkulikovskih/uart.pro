<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Notification;
use App\Services\NotificationService;

class BookingController extends Controller
{
    use AuthorizesRequests;

    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = auth()->user();
        
        if ($user->isMusician()) {
            $bookings = $user->musicianBookings()
                ->with(['user', 'musician'])
                ->latest()
                ->paginate(10);
        } else {
            $bookings = $user->bookings()
                ->with(['user', 'musician'])
                ->latest()
                ->paginate(10);
        }

        return view('bookings.index', compact('bookings'));
    }

    public function create($musician_id)
    {
        $musician = User::findOrFail($musician_id);
        
        return view('bookings.create', [
            'musician' => $musician,
            'timeSlots' => [
                '09:00' => '09:00',
                '10:00' => '10:00',
                '11:00' => '11:00',
                '12:00' => '12:00',
                '13:00' => '13:00',
                '14:00' => '14:00',
                '15:00' => '15:00',
                '16:00' => '16:00',
                '17:00' => '17:00',
                '18:00' => '18:00',
                '19:00' => '19:00',
                '20:00' => '20:00',
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'musician_id' => 'required|exists:users,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'duration' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Создаем объект DateTime для начала бронирования
        $startTime = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['time']);
        // Создаем объект DateTime для окончания бронирования
        $endTime = $startTime->copy()->addHours((int)$validated['duration']);

        $booking = auth()->user()->bookings()->create([
            'musician_id' => $validated['musician_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'event_type' => 'performance',
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Загружаем отношения для уведомления
        $booking->load(['user', 'musician']);

        // Отправляем уведомление о новом заказе
        $this->notificationService->sendNewBookingNotification($booking);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Заказ успешно создан!');
    }

    public function show(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id && auth()->id() !== $booking->musician_id) {
            abort(403);
        }
        
        return view('bookings.show', compact('booking'));
    }

    public function calendar()
    {
        if (!auth()->user()->isMusician()) {
            abort(403, 'Только музыканты могут просматривать календарь выступлений.');
        }
        
        $bookings = auth()->user()->musicianBookings()
            ->with(['user'])
            ->get();
            
        return view('bookings.calendar', compact('bookings'));
    }

    public function confirm(Booking $booking)
    {
        if (auth()->id() !== $booking->musician_id) {
            abort(403);
        }

        $booking->update(['status' => 'confirmed']);

        // Создаем уведомление для пользователя
        Notification::create([
            'user_id' => $booking->user_id,
            'type' => 'booking_confirmed',
            'message' => "Ваше бронирование на {$booking->start_time->format('d.m.Y H:i')} подтверждено музыкантом {$booking->musician->name}",
            'booking_id' => $booking->id
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Бронирование подтверждено.');
    }

    public function cancel(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id && auth()->id() !== $booking->musician_id) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        // Создаем уведомление
        if (auth()->id() === $booking->musician_id) {
            // Если отменяет музыкант, уведомляем пользователя
            Notification::create([
                'user_id' => $booking->user_id,
                'type' => 'booking_cancelled',
                'message' => "Ваше бронирование на {$booking->start_time->format('d.m.Y H:i')} отменено музыкантом {$booking->musician->name}",
                'booking_id' => $booking->id
            ]);
        } else {
            // Если отменяет пользователь, уведомляем музыканта
            Notification::create([
                'user_id' => $booking->musician_id,
                'type' => 'booking_cancelled',
                'message' => "Бронирование на {$booking->start_time->format('d.m.Y H:i')} отменено пользователем {$booking->user->name}",
                'booking_id' => $booking->id
            ]);
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Бронирование отменено.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update([
            'status' => $validated['status'],
        ]);

        // Отправляем уведомление об изменении статуса
        $this->notificationService->sendBookingStatusNotification($booking);

        return redirect()->back()
            ->with('success', 'Статус заказа обновлен!');
    }
}

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MusicianController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Маршруты для бронирований
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{musician_id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    // Маршрут для календаря музыканта
    Route::get('/bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/bookings/{booking}/messages', [MessageController::class, 'store'])->name('messages.store');

    // Маршрут для страницы музыкантов
    Route::get('/musicians', [MusicianController::class, 'index'])->name('musicians.index');
    Route::get('/musicians/{musician}', [MusicianController::class, 'show'])->name('musicians.show');
    Route::post('/musicians/{musician}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Маршруты для чата
    Route::get('/chat/{user}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store');

    // Маршруты для уведомлений
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Маршруты для отзывов
    Route::post('/reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond');
    Route::post('/reviews/{review}/react', [ReviewController::class, 'react'])->name('reviews.react');
    Route::post('/reviews/{review}/moderate', [ReviewController::class, 'moderate'])->name('reviews.moderate');
    Route::delete('/reviews/{review}', [ReviewController::class, 'delete'])->name('reviews.delete');
});

// Маршруты аутентификации
require __DIR__.'/auth.php';

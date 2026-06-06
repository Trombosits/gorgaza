<?php

use Illuminate\Support\Facades\Route; // Pastikan ini ada di paling atas
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('frontend.landing_page'); 
});

Route::get('/register', function () {
    return view('frontend.register'); 
});

Route::get('/login', function () {
    return view('frontend.login'); 
});

Route::get('/booking', function () {
    return view('frontend.booking'); 
});

Route::get('/booking-schedule', function () {
    return view('frontend.booking_schedule'); 
});

Route::get('/booking-confirm', function () {
    return view('frontend.booking_confirm'); 
});

// Route untuk mengambil jadwal yang sudah di-booking
Route::get('/api/schedules', [BookingController::class, 'getSchedules']);

// Route untuk menerima data dari JavaScript
Route::post('/api/bookings', [BookingController::class, 'store']);

// Route untuk Autentikasi
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
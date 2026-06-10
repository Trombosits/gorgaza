<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\FinanceReportController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Frontend.landing_page');
});

Route::get('/landing_page', function () {
    return redirect('/');
});

Route::get('/register', function () {
    return view('Frontend.register');
});

Route::get('/login', function () {
    return view('Frontend.login');
});

Route::get('/booking', function () {
    return view('Frontend.booking');
});

Route::get('/booking-schedule', function () {
    return view('Frontend.booking_schedule');
});

Route::get('/booking-confirm', function () {
    return view('Frontend.booking_confirm');
});

Route::get('/api/schedules', [BookingController::class, 'getSchedules']);
Route::post('/api/bookings', [BookingController::class, 'store']);
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/facilities', FacilityController::class)
        ->names('admin.facilities')
        ->except(['show']);

    Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('admin.reservations.show');

    Route::get('/reports/finance', [FinanceReportController::class, 'index'])->name('admin.reports.finance');
    Route::get('/reports/finance/export', [FinanceReportController::class, 'export'])->name('admin.reports.finance.export');
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.updateStatus');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
});

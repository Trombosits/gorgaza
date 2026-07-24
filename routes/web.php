<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CafeMenuController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FinanceReportController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SiteImageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingHistoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PembayaranController;
use App\Models\CafeMenu;
use App\Models\SiteImage;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Models\Facility;

Route::get('/', function () {
    try {
        $cafeMenus = CafeMenu::where('is_active', true)
            ->orderBy('kategori')
            ->orderBy('urutan')
            ->orderBy('nama_menu')
            ->get()
            ->groupBy('kategori');

        $siteImages = SiteImage::where('is_active', true)
            ->orderBy('kategori')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get()
            ->groupBy('kategori');
    } catch (\Throwable $e) {
        $cafeMenus = collect();
        $siteImages = collect();
    }

    $setting = Setting::firstOrCreate([], [
    'nominal_dp' => 5000,
    'jam_buka' => '08:00:00',
    'jam_tutup' => '23:00:00',
    ]);

    $facilities = Facility::all()->keyBy('jenis');

    return view(
        'Frontend.landing_page',
        compact(
            'cafeMenus',
            'siteImages',
            'setting',
            'facilities'
        )
);
})->name('landing');

Route::get('/landing_page', function () {
    return redirect('/');
});

Route::get('/register', function () {
    return view('Frontend.register');
})->name('register');

Route::get('/login', function () {
    return view('Frontend.login');
})->name('login');

Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Jadwal boleh dilihat publik dari landing page.
Route::get('/api/schedules', [BookingController::class, 'getSchedules']);

// Booking dan pembayaran wajib login menggunakan session auth_user project ini.
Route::middleware('customer.auth')->group(function () {
    Route::get('/booking', function () {
        return view('Frontend.booking');
    })->name('booking');

    Route::get('/booking-schedule', function () {
    $setting = \App\Models\Setting::firstOrFail();
    return view('Frontend.booking_schedule', compact('setting'));
    })->name('booking.schedule');

    Route::get('/booking-confirm', function () {
        return view('Frontend.booking_confirm');
    })->name('booking.confirm');

    Route::get('/booking-history', [BookingHistoryController::class, 'index'])->name('booking.history');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/pembayaran/{transaction_id}', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::post('/api/bookings', [BookingController::class, 'store']);
});

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/facilities', FacilityController::class)
        ->names('admin.facilities')
        ->except(['show']);

    Route::get('/settings', [SettingController::class, 'edit'])
        ->name('admin.settings.edit');

    Route::put('/settings', [SettingController::class, 'update'])
        ->name('admin.settings.update');

    Route::resource('/cafe-menus', CafeMenuController::class)
        ->names('admin.cafe-menus')
        ->except(['show']);

    Route::resource('/site-images', SiteImageController::class)
        ->names('admin.site-images')
        ->except(['show']);

    Route::get('/feedbacks', [AdminFeedbackController::class, 'index'])->name('admin.feedbacks.index');
    Route::get('/feedbacks/{feedback}', [AdminFeedbackController::class, 'show'])->name('admin.feedbacks.show');
    Route::delete('/feedbacks/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('admin.feedbacks.destroy');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('admin.reservations.show');
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.updateStatus');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('admin.reservations.destroy');

    Route::get('/reports/finance', [FinanceReportController::class, 'index'])->name('admin.reports.finance');
    Route::get('/reports/finance/export', [FinanceReportController::class, 'export'])->name('admin.reports.finance.export');
});

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\User;
use App\Services\ReservationStatusService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        ReservationStatusService::markOutOfTime();

        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalRevenue = Transaction::where('status_pembayaran', 'Paid')->sum('total_tagihan');
        $monthlyRevenue = Transaction::where('status_pembayaran', 'Paid')
            ->whereBetween('waktu_transaksi', [$startOfMonth, $endOfMonth])
            ->sum('total_tagihan');

        $todayReservations = Reservation::whereDate('waktu_mulai', $today)->count();
        $pendingPayments = Transaction::where('status_pembayaran', 'Pending')->sum('total_tagihan');

        $statusSummary = Reservation::select('status_main', DB::raw('COUNT(*) as total'))
            ->groupBy('status_main')
            ->pluck('total', 'status_main');

        $monthlyChart = [];
        for ($i = 1; $i <= 12; $i++) {

        $monthlyChart[] = Transaction::whereYear('waktu_transaksi', now()->year)
        ->whereMonth('waktu_transaksi', $i)
        ->where('status_pembayaran', 'Paid')
        ->sum('total_tagihan');

        }

        $paymentSummary = Transaction::select('status_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('status_pembayaran')
            ->pluck('total', 'status_pembayaran');

        $setting = Setting::first();
        $badminton = Facility::where('jenis', 'Badminton')->first();
        $billiard = Facility::where('jenis', 'Billiard')->first();

        $todaySchedules = Reservation::with(['facility', 'transaction.user'])
            ->whereDate('waktu_mulai', today())
            ->orderBy('waktu_mulai')
            ->limit(5)
            ->get();

        $nextBooking = Reservation::with(['facility', 'transaction.user'])
            ->where('waktu_mulai', '>=', now())
            ->orderBy('waktu_mulai')
            ->first();

        $activePromo = Facility::whereNotNull('harga_promo')
            ->whereNotNull('promo_mulai')
            ->whereNotNull('promo_selesai')
            ->where('is_active',1)
            ->get();

        $badminton = Facility::where('jenis','Badminton')->first();
        $billiard  = Facility::where('jenis','Billiard')->first();

        return view('Admin.dashboard', [
            'totalUsers' => User::where('role', 'customer')->count(),
            'totalFacilities' => Facility::whereIn('jenis', ['Badminton', 'Billiard'])->count(),
            'totalReservations' => Reservation::count(),
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'todayReservations' => $todayReservations,
            'pendingPayments' => $pendingPayments,
            'statusSummary' => $statusSummary,
            'paymentSummary' => $paymentSummary,
            'latestReservations' => Reservation::with(['facility', 'transaction.user'])
                ->latest()
                ->limit(6)
                ->get(),

            'setting' => $setting,
            'badminton' => $badminton,
            'billiard' => $billiard,
            'todaySchedules' => $todaySchedules,
            'nextBooking' => $nextBooking,
            'activePromo' => $activePromo,
            'monthlyChart' => $monthlyChart,
        ]);
    }
}

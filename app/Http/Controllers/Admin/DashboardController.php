<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
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

        $paymentSummary = Transaction::select('status_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('status_pembayaran')
            ->pluck('total', 'status_pembayaran');

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
        ]);
    }
}

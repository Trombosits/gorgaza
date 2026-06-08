<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Admin.dashboard', [
            'totalUsers' => User::where('role', 'customer')->count(),
            'totalFacilities' => Facility::count(),
            'totalReservations' => Reservation::count(),
            'totalRevenue' => Transaction::where('status_pembayaran', 'Paid')->sum('total_tagihan'),
            'latestReservations' => Reservation::with(['facility', 'transaction.user'])
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}

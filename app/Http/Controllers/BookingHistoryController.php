<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\ReservationStatusService;
use Illuminate\Http\Request;

class BookingHistoryController extends Controller
{
    public function index(Request $request)
    {
        ReservationStatusService::markOutOfTime();

        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        if (!$userId) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk melihat riwayat booking.');
        }

        $transactions = Transaction::with(['reservations.facility'])
            ->where('user_id', $userId)
            ->orderByDesc('waktu_transaksi')
            ->orderByDesc('id')
            ->paginate(8);

        return view('Frontend.booking_history', compact('transactions'));
    }
}

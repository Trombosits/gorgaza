<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ReservationStatusService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        ReservationStatusService::markOutOfTime();

        $query = Reservation::with(['facility', 'transaction.user'])->latest();

        if ($request->filled('status')) {
            $query->where('status_main', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('waktu_mulai', $request->tanggal);
        }

        return view('Admin.reservations.index', [
            'reservations' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function show(Reservation $reservation)
    {
        ReservationStatusService::markOutOfTime();
        $reservation->refresh();
        $reservation->load(['facility', 'transaction.user']);
        return view('Admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
{
    $data = $request->validate([
        'status_main' => 'required|in:Booking,Confirmed,Cancelled,Completed',
        'status_pembayaran' => 'required|in:Pending,Partial,Paid,Cancelled',
    ]);

    // update status booking
    $reservation->update([
        'status_main' => $data['status_main']
    ]);

    $transaction = $reservation->transaction;

    $updateData = [
        'status_pembayaran' => $data['status_pembayaran'],
    ];

    switch ($data['status_pembayaran']) {

        case 'Paid':

            $updateData['nominal_dp'] = $transaction->total_tagihan;
            $updateData['sisa_pembayaran'] = 0;

        break;

        case 'Pending':

            $updateData['nominal_dp'] = 0;
            $updateData['sisa_pembayaran'] = $transaction->total_tagihan;

        break;

        case 'Cancelled':

            $updateData['nominal_dp'] = 0;
            $updateData['sisa_pembayaran'] = $transaction->total_tagihan;

        break;

    }

    $transaction->update($updateData);

    return back()->with('success','Status berhasil diperbarui.');
}

    public function destroy(Reservation $reservation)
    {
        $transaction = $reservation->transaction;
        $reservation->delete();

        if ($transaction && $transaction->reservations()->count() === 0) {
            $transaction->delete();
        }

        return redirect('/admin/reservations')->with('success', 'Booking berhasil dihapus.');
    }
}

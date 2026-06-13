<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index($transaction_id)
    {
        // 1. Ambil data transaksi beserta detail reservasi, fasilitas, dan data user
        $transaction = Transaction::with(['reservations.facility', 'user'])->findOrFail($transaction_id);

        // 2. Proteksi Keamanan: Pastikan transaksi ini benar milik user yang sedang login
        // Menyesuaikan dengan sistem session('auth_user') yang Anda gunakan
        if (!session()->has('auth_user') || session('auth_user.id') !== $transaction->user_id) {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman pembayaran ini.');
        }

        // 3. Jika status sudah lunas, halaman tetap ditampilkan agar user bisa mengecek bukti/status Paid.

        // 4. Tampilkan halaman pembayaran/detail transaksi dari folder Frontend
        return view('Frontend.pembayaran', compact('transaction'));
    }
}
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

        // 3. Jika status sudah lunas, redirect ke halaman utama dengan pesan khusus
        if ($transaction->status_pembayaran === 'Paid') {
            return redirect('/')->with('success', 'Transaksi ini sudah lunas! Terima kasih.');
        }

        // 4. 🌟 PERBAIKAN DI SINI: Tampilkan halaman pembayaran dari folder Frontend
        return view('Frontend.pembayaran', compact('transaction'));
    }
}
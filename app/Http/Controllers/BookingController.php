<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // WAJIB ada agar Request $request tidak error
use App\Models\User;
use App\Models\Transaction;
use App\Models\Reservation;
use App\Models\Facility;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Pindahkan fungsi store Anda ke SINI, di dalam kurung kurawal Class
    public function store(Request $request) 
    {
        // 1. Ambil data payload dari Fetch API JavaScript
        $draft = $request->input('draft');
        $userData = $request->input('user');

        // Gunakan DB Transaction agar jika ada gagal insert, semua dibatalkan (rollback)
        DB::beginTransaction();

        try {
            // 2. Cek apakah user sudah ada di DB berdasarkan email, jika belum buat baru
            $user = User::firstOrCreate(
                ['email' => $userData['email']], 
                [
                    'nama' => $userData['name'], 
                    'no_hp' => $userData['phone'] ?? '0000000000' 
                ]
            );

            // 3. Tentukan Fasilitas & Hitung Durasi/Subtotal
            $facility = Facility::findOrFail($draft['facility_id']);
            
            $waktuMulai = Carbon::parse($draft['waktu_mulai']);
            $waktuSelesai = Carbon::parse($draft['waktu_selesai']);
            
            $durasiJam = $waktuMulai->diffInHours($waktuSelesai);
            if ($durasiJam == 0) $durasiJam = 1; 
            
            $subtotal = $facility->harga_per_jam * $durasiJam;

            // 4. Insert ke tabel `transactions`
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_tagihan' => $subtotal,
                'status_pembayaran' => 'Pending',
                'waktu_transaksi' => now()
            ]);

            // 5. Insert ke tabel `reservations`
            Reservation::create([
                'transaction_id' => $transaction->id,
                'facility_id' => $facility->id,
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
                'subtotal' => $subtotal,
                'status_main' => 'Booking'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil disimpan!',
                'transaction_id' => $transaction->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Tambahkan fungsi ini di dalam class BookingController
    public function getSchedules(Request $request)
    {
        $tanggal = $request->query('tanggal'); // Format: YYYY-MM-DD
        $facility_id = $request->query('facility_id');

        // Cari data di tabel reservations berdasarkan fasilitas dan tanggal
        $reservations = Reservation::where('facility_id', $facility_id)
            ->whereDate('waktu_mulai', $tanggal)
            ->get();

        // Ubah format waktu_mulai dan waktu_selesai menjadi format array jam, 
        // Contoh: ["08:00 - 09:00", "10:00 - 11:00"]
        $bookedTimes = $reservations->map(function($res) {
            $start = Carbon::parse($res->waktu_mulai)->format('H:i');
            $end = Carbon::parse($res->waktu_selesai)->format('H:i');
            return $start . ' - ' . $end;
        })->toArray();

        return response()->json([
            'success' => true,
            'booked_times' => $bookedTimes
        ]);
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $draft = $request->input('draft');
        $userData = $request->input('user');

        DB::beginTransaction();

        try {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'nama' => $userData['name'],
                    'no_hp' => $userData['phone'] ?? '0000000000',
                    'password' => bcrypt('customer123'),
                    'role' => 'customer',
                ]
            );

            $facility = Facility::findOrFail($draft['facility_id']);

            $waktuMulai = Carbon::parse($draft['waktu_mulai']);
            $waktuSelesai = Carbon::parse($draft['waktu_selesai']);

            $isBentrok = Reservation::where('facility_id', $facility->id)
                ->whereIn('status_main', ['Booking', 'Confirmed'])
                ->where('waktu_mulai', '<', $waktuSelesai)
                ->where('waktu_selesai', '>', $waktuMulai)
                ->exists();

            if ($isBentrok) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Jam tersebut sudah dibooking. Silakan pilih slot lain.',
                ], 422);
            }

            $durasiJam = max(1, $waktuMulai->diffInHours($waktuSelesai));
            $subtotal = $facility->harga_per_jam * $durasiJam;

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_tagihan' => $subtotal,
                'status_pembayaran' => 'Pending',
                'metode_pembayaran' => $draft['metode_pembayaran'] ?? 'Pay On Place',
                'waktu_transaksi' => now(),
            ]);

            Reservation::create([
                'transaction_id' => $transaction->id,
                'facility_id' => $facility->id,
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
                'subtotal' => $subtotal,
                'status_main' => 'Booking',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil disimpan!',
                'transaction_id' => $transaction->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getSchedules(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $facilityId = $request->query('facility_id');

        $reservations = Reservation::where('facility_id', $facilityId)
            ->whereDate('waktu_mulai', $tanggal)
            ->whereIn('status_main', ['Booking', 'Confirmed'])
            ->get();

        $bookedTimes = $reservations->map(function ($res) {
            $start = Carbon::parse($res->waktu_mulai)->format('H:i');
            $end = Carbon::parse($res->waktu_selesai)->format('H:i');
            return $start . ' - ' . $end;
        })->toArray();

        return response()->json([
            'success' => true,
            'booked_times' => $bookedTimes,
        ]);
    }
}

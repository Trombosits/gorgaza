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
                ->whereNotIn('status_main', ['Cancelled'])
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
        $facilityId = $request->query('facility_id') ?? $request->query('facilityId');
        $tanggal = $request->query('tanggal') ?? $request->query('date');

        if (!$facilityId || !$tanggal) {
            return response()->json([
                'success' => true,
                'booked_times' => [],
                'reservations' => [],
            ]);
        }

        try {
            $dayStart = Carbon::parse($tanggal)->startOfDay();
            $dayEnd = Carbon::parse($tanggal)->endOfDay();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Format tanggal tidak valid.',
                'booked_times' => [],
                'reservations' => [],
            ], 422);
        }

        $reservations = Reservation::where('facility_id', $facilityId)
            ->whereNotIn('status_main', ['Cancelled'])
            ->where('waktu_mulai', '<', $dayEnd)
            ->where('waktu_selesai', '>', $dayStart)
            ->orderBy('waktu_mulai')
            ->get();

        $bookedTimes = collect();

        foreach ($reservations as $reservation) {
            $start = Carbon::parse($reservation->waktu_mulai)->copy();
            $end = Carbon::parse($reservation->waktu_selesai)->copy();

            // Samakan ke slot per jam yang dipakai di frontend: "08:00 - 09:00"
            $cursor = $start->copy()->minute(0)->second(0);

            while ($cursor->lt($end)) {
                $slotEnd = $cursor->copy()->addHour();

                if ($slotEnd->gt($start) && $cursor->lt($end)) {
                    $bookedTimes->push($cursor->format('H:i') . ' - ' . $slotEnd->format('H:i'));
                }

                $cursor->addHour();
            }
        }

        return response()->json([
            'success' => true,
            'booked_times' => $bookedTimes->unique()->values(),
            'reservations' => $reservations->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'start' => Carbon::parse($reservation->waktu_mulai)->format('H:i'),
                    'end' => Carbon::parse($reservation->waktu_selesai)->format('H:i'),
                    'status' => $reservation->status_main,
                ];
            })->values(),
        ]);
    }

    // Alias cadangan kalau ada route lama yang memanggil schedules()
    public function schedules(Request $request)
    {
        return $this->getSchedules($request);
    }
}

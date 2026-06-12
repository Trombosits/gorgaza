<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;

class ReservationStatusService
{
    /**
     * Ubah booking yang sudah melewati jam mulai lebih dari satu menit menjadi Out of Time.
     * Status Completed dan Cancelled tidak disentuh agar riwayat tetap aman.
     */
    public static function markOutOfTime(): int
    {
        return Reservation::whereIn('status_main', ['Booking', 'Confirmed'])
            ->where('waktu_mulai', '<', Carbon::now()->subMinute())
            ->update(['status_main' => 'Out of Time']);
    }

    public static function statusOptions(): array
    {
        return ['Booking', 'Confirmed', 'Cancelled', 'Completed', 'Out of Time'];
    }

    public static function activeScheduleStatuses(): array
    {
        return ['Booking', 'Confirmed', 'Completed', 'Out of Time'];
    }
}

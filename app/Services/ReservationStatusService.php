<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;

class ReservationStatusService
{
    /**
     * Booking yang sudah melewati jam selesai otomatis dianggap Selesai.
     * Status Cancelled tidak disentuh agar riwayat pembatalan tetap aman.
     * Nama method dibiarkan sama supaya pemanggil lama tetap aman.
     */
    public static function markOutOfTime(): int
    {
        return Reservation::whereIn('status_main', ['Booking', 'Confirmed', 'Out of Time'])
            ->where('waktu_selesai', '<=', Carbon::now())
            ->update(['status_main' => 'Completed']);
    }

    public static function statusOptions(): array
    {
        return ['Booking', 'Confirmed', 'Cancelled', 'Completed'];
    }

    public static function activeScheduleStatuses(): array
    {
        return ['Booking', 'Confirmed', 'Completed'];
    }
}

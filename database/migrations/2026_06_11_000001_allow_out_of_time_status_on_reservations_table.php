<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL enum lama tidak bisa menerima status baru. Ubah ke VARCHAR agar status mudah dikembangkan.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE reservations MODIFY status_main VARCHAR(30) NOT NULL DEFAULT 'Booking'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE reservations SET status_main = 'Booking' WHERE status_main = 'Out of Time'");
            DB::statement("ALTER TABLE reservations MODIFY status_main ENUM('Booking', 'Confirmed', 'Cancelled', 'Completed') NOT NULL DEFAULT 'Booking'");
        }
    }
};

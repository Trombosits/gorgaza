<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE transactions
            MODIFY status_pembayaran
            ENUM('Pending','Partial','Paid','Cancelled')
            NOT NULL
            DEFAULT 'Pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE transactions
            MODIFY status_pembayaran
            ENUM('Pending','Paid','Cancelled')
            NOT NULL
            DEFAULT 'Pending'
        ");
    }
};
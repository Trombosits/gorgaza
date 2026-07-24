<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();

        // Booking
        $table->integer('nominal_dp')->default(5000);
        $table->time('jam_buka')->default('08:00:00');
        $table->time('jam_tutup')->default('23:00:00');

        // Kontak
        $table->string('whatsapp')->nullable();
        $table->string('email')->nullable();
        $table->text('alamat')->nullable();

        // Sosial Media
        $table->text('maps')->nullable();
        $table->string('instagram')->nullable();
        $table->string('tiktok')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

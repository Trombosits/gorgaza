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
    Schema::table('facilities', function (Blueprint $table) {

        $table->integer('harga_promo')->nullable()->after('harga_per_jam');

        $table->time('promo_mulai')->nullable()->after('harga_promo');

        $table->time('promo_selesai')->nullable()->after('promo_mulai');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('facilities', function (Blueprint $table) {

        $table->dropColumn([
            'harga_promo',
            'promo_mulai',
            'promo_selesai'
        ]);

    });
}
};

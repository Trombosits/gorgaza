<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nama')) {
                $table->string('nama', 100)->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('nama');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'customer'])->default('customer')->after('password');
            }
        });

        // Biar kode lama yang pakai kolom `nama` tetap aman walaupun Laravel default punya kolom `name`.
        DB::statement("UPDATE users SET nama = name WHERE nama IS NULL AND name IS NOT NULL");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
            if (Schema::hasColumn('users', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }
};

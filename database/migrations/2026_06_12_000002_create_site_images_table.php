<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('site_images')) {
            Schema::create('site_images', function (Blueprint $table) {
                $table->id();
                $table->string('judul', 120);
                $table->string('kategori', 80)->default('galeri');
                $table->string('path_gambar');
                $table->string('alt_text')->nullable();
                $table->unsignedInteger('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (DB::table('site_images')->count() === 0) {
            $now = now();
            $images = [
                ['Hero Slider', 'Hero Badminton 1', 'images/Bulutangkis-9.jpeg', 'Lapangan badminton GOR GAZA', 1],
                ['Hero Slider', 'Hero Billiard', 'images/Billiard.jpeg', 'Meja billiard GOR GAZA', 2],
                ['Hero Slider', 'Hero Badminton 2', 'images/Bulutangkis-6.jpeg', 'Suasana badminton GOR GAZA', 3],
                ['Hero Slider', 'Hero Badminton 3', 'images/Bulutangkis-2.jpeg', 'Lapangan badminton indoor', 4],
                ['Hero Slider', 'Hero Billiard 2', 'images/Billiard-2.jpeg', 'Area billiard GOR GAZA', 5],
                ['Hero Slider', 'Hero Area Duduk', 'images/Kursi.jpeg', 'Area duduk GOR GAZA', 6],
                ['Badminton', 'Lapangan Badminton', 'images/Bulutangkis-2.jpeg', 'Lapangan badminton', 1],
                ['Badminton', 'Badminton Indoor', 'images/Bulutangkis-3.jpeg', 'Badminton indoor', 2],
                ['Badminton', 'Permainan Badminton', 'images/Bulutangkis-4.jpeg', 'Permainan badminton', 3],
                ['Badminton', 'Olahraga Indoor', 'images/Bulutangkis-5.jpeg', 'Olahraga indoor', 4],
                ['Billiard', 'Billiard Premium', 'images/Billiard-1.jpeg', 'Billiard premium', 1],
                ['Billiard', 'Meja Billiard', 'images/Billiard-2.jpeg', 'Meja billiard', 2],
                ['Billiard', 'Ruang Billiard', 'images/Billiard-3.jpeg', 'Ruang billiard', 3],
                ['Billiard', 'Billiard Lounge', 'images/Billiard-4.jpeg', 'Billiard lounge', 4],
                ['Pendukung', 'Mushola', 'images/Mushola-1.jpeg', 'Mushola', 1],
                ['Pendukung', 'Area Duduk', 'images/Kursi.jpeg', 'Area duduk', 2],
                ['Pendukung', 'Toko', 'images/Toko.jpeg', 'Toko', 3],
                ['Pendukung', 'Toilet', 'images/Toilet.jpeg', 'Toilet', 4],
                ['Pendukung', 'Parkiran', 'images/Parkiran.jpeg', 'Parkiran', 5],
                ['Pendukung', 'Area Parkir', 'images/ParkiranAll.jpeg', 'Area parkir', 6],
            ];

            foreach ($images as [$kategori, $judul, $path, $alt, $urutan]) {
                DB::table('site_images')->insert([
                    'kategori' => $kategori,
                    'judul' => $judul,
                    'path_gambar' => $path,
                    'alt_text' => $alt,
                    'urutan' => $urutan,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_images');
    }
};

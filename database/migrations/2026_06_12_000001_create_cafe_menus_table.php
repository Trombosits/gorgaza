<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cafe_menus')) {
            Schema::create('cafe_menus', function (Blueprint $table) {
                $table->id();
                $table->string('nama_menu', 120);
                $table->string('kategori', 80)->default('Menu Kafe');
                $table->integer('harga')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('gambar')->nullable();
                $table->unsignedInteger('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (DB::table('cafe_menus')->count() === 0) {
            $now = now();
            $menus = [
                ['Main Course', 'Original', 8000, 'Dadar / ceplok / orek telor', 1],
                ['Main Course', 'Cumi', 13000, 'Dadar / ceplok / orek telor + cumi', 2],
                ['Main Course', 'Tongkol', 13000, 'Dadar / ceplok / orek telor + tongkol', 3],
                ['Main Course', 'Teri', 13000, 'Dadar / ceplok / orek telor + teri', 4],
                ['Main Course', 'Paru', 13000, 'Dadar / ceplok / orek telor + paru', 5],
                ['Main Course', 'Daging', 13000, 'Dadar / ceplok / orek telor + daging', 6],
                ['Mie & Extra', 'Mie goreng polos', null, null, 1],
                ['Mie & Extra', 'Mie goreng telor', null, null, 2],
                ['Mie & Extra', 'Mie kuah polos', null, null, 3],
                ['Mie & Extra', 'Mie kuah telor', null, null, 4],
                ['Mie & Extra', 'Nasi', 5000, null, 5],
                ['Mie & Extra', 'Nasi setengah', 3000, null, 6],
                ['Mie & Extra', 'Telor dadar/ceplok/orek', 5000, null, 7],
                ['Mie & Extra', 'Oseng sambal', 5000, null, 8],
                ['Mie & Extra', 'Tahu / Tempe', 2000, null, 9],
                ['Mie & Extra', 'Sambal bawang / Kerupuk', 2000, null, 10],
                ['Minuman & Snack', 'Air mineral', 3000, null, 1],
                ['Minuman & Snack', 'Isoplus / Floridina / Teh Pucuk', 4000, null, 2],
                ['Minuman & Snack', 'Teh manis', 4000, null, 3],
                ['Minuman & Snack', 'Lemon tea / Lemongrass tea', 6000, null, 4],
                ['Minuman & Snack', 'Teh tarik / Jahe', 6000, null, 5],
                ['Minuman & Snack', 'Jus jeruk/strawberry/mangga', 8000, null, 6],
                ['Minuman & Snack', 'Jus alpukat', 10000, null, 7],
                ['Minuman & Snack', 'Kopi hot/cold', null, null, 8],
                ['Minuman & Snack', 'Sosis kentang', null, null, 9],
            ];

            foreach ($menus as [$kategori, $nama, $harga, $deskripsi, $urutan]) {
                DB::table('cafe_menus')->insert([
                    'kategori' => $kategori,
                    'nama_menu' => $nama,
                    'harga' => $harga,
                    'deskripsi' => $deskripsi,
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
        Schema::dropIfExists('cafe_menus');
    }
};

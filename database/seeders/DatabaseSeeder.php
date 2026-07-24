<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gorgaza.test'],
            [
                'name' => 'Admin GOR GAZA',
                'nama' => 'Admin GOR GAZA',
                'no_hp' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $this->call([
            SettingSeeder::class,
        ]);

        Facility::updateOrCreate(
            ['id' => 1],
            [
                'nama_fasilitas' => 'Lapangan Badminton',
                'jenis' => 'Badminton',
                'harga_per_jam' => 30000,
                'deskripsi' => 'Lapangan badminton indoor GOR GAZA.',
                'is_active' => true,
            ]
        );

        Facility::updateOrCreate(
            ['id' => 2],
            [
                'nama_fasilitas' => 'Meja Billiard',
                'jenis' => 'Billiard',
                'harga_per_jam' => 30000,
                'deskripsi' => 'Fasilitas billiard GOR GAZA.',
                'is_active' => true,
            ]
        );
    }
}

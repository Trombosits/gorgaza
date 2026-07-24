<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'nominal_dp' => 5000,
                'jam_buka' => '08:00:00',
                'jam_tutup' => '23:00:00',

                'whatsapp' => '082215309779',
                'email' => 'admin@gorgaza.com',
                'alamat' => 'Jl. Ciguruwik No.216, RT.04/RW.13, Cinunuk, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40624',

                'maps' => 'https://maps.app.goo.gl/H4FSEotqp3G2Bndx6',
                'instagram' => '',
                'tiktok' => '',
            ]
        );
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nominal_dp',
        'jam_buka',
        'jam_tutup',

        'whatsapp',
        'email',
        'alamat',

        'maps',
        'instagram',
        'tiktok',
    ];
}
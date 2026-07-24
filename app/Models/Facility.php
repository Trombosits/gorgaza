<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'nama_fasilitas',
        'jenis',
        'harga_per_jam',
        'deskripsi',
        'is_active',
        'harga_promo',
        'promo_mulai',
        'promo_selesai',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

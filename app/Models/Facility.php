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
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

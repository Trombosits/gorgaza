<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeMenu extends Model
{
    protected $fillable = [
        'nama_menu',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga' => 'integer',
        'urutan' => 'integer',
    ];
}

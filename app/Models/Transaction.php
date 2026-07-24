<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'total_tagihan',

        'nominal_dp',
        'sisa_pembayaran',

        'status_pembayaran',
        'metode_pembayaran',
        'waktu_transaksi',
    ];

    protected $casts = [
        'total_tagihan' => 'integer',
        'nominal_dp' => 'integer',
        'sisa_pembayaran' => 'integer',
        'waktu_transaksi' => 'datetime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

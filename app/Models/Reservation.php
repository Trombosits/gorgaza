<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'transaction_id',
        'facility_id',
        'waktu_mulai',
        'waktu_selesai',
        'subtotal',
        'status_main',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}

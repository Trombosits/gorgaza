<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public $timestamps = false;
    protected $fillable = ['transaction_id', 'facility_id', 'waktu_mulai', 'waktu_selesai', 'subtotal', 'status_main'];
}
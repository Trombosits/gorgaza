<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'nama', 
        'no_hp', 
        'email', 
        'password',
        'created_at'
    ];

    protected $hidden = [
        'password',
    ];
}
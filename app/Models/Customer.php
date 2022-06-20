<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'handphone',
        'tgl_beli',
    ];
}

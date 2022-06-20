<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class STNK extends Model
{
    protected $fillable = [
        'cust_id',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'cust_id', 'id');
    }
}

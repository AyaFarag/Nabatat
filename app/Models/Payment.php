<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'status'
    ];

    public function order() {
        return $this -> hasMany(Order::class );
    }
}

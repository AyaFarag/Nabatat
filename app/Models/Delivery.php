<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'name','phone','nationalId','image'
    ];

    public function order(){
        return $this ->hasMany(Order::class );
    }
}

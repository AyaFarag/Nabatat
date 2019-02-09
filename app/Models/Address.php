<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        "address", "city_id", "phone", "first_name", "last_name"
    ];

    public function user() {
        return $this -> belongsTo(User::class);
    }

    public function city() {
        return $this -> belongsTo(City::class);
    }

    public function order() {
        return $this -> hasMany(Order::class);
    }
}

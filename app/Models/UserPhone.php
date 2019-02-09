<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    protected $table = "users_phones";

    protected $fillable = [
        "phone","user_id"
    ];

    protected $casts = ["confirmed" => "boolean"];

    public $timestamps = false;

    public function user() {
        return $this -> belongsTo(User::class);
    }
}

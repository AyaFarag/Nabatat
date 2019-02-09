<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        "first_name", "last_name", "email", "password", "device_token"
    ];

    protected $hidden = [
        "password", "remember_token",
    ];

    protected $casts = ["activated" => "boolean"];

    protected $dates = ["created_at"];

    public function setPasswordAttribute($value) {
        $this -> attributes["password"] = Hash::needsReHash($value)
            ? Hash::make($value)
            : $value;
    }

    public function scopeSearch($query, $search) {
        return $query -> where(function ($query) use ($search) {
            $query -> where("name", "like", "%{$search}%")
                -> orWhere("email", "like", "%{$search}%");
        });
    }

    public function scopeWithMoneySpent($query) {
        $query -> selectRaw("orders.*, users.*, IFNULL(SUM(total), 0) as money_spent")
            -> leftJoin("orders", "user_id", "=", "users.id")
            -> leftJoin("payment_detailes", "orders.id", "=", "order_id")
            -> groupBy("users.id");
    }

    public function ordersCount()
    {
        return $this -> hasOne(Order::class)
            -> selectRaw("user_id, count(*) as aggregate")
            -> groupBy("user_id");
    }

    public function getOrdersCountAttribute()
    {
        if (!array_key_exists("ordersCount", $this -> relations))
            $this -> load("ordersCount");

        $relation = $this -> getRelation("ordersCount");

        return $relation ? $relation -> aggregate : 0;
    }

    public function addresses() {
        return $this -> hasMany(Address::class);
    }

    public function orders() {
        return $this -> hasMany(Order::class);
    }

    public function requests() {
        return $this -> hasMany(ServiceRequest::class );
    }

    public function carts() {
        return $this -> hasMany(Cart::class);
    }


    public function rates() {
        return $this -> hasMany(Rate::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class,'carts')->withPivot('quantity')->withTimestamps();
    }

    public function phones()
    {
        return $this -> hasMany(UserPhone::class);
    }

}

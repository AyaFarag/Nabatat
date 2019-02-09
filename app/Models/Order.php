<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PENDING    = 0;
    const CONFIRMED  = 1;
    const PREPARING  = 2;
    const ON_THE_WAY = 3;
    const RETURNED   = 4;
    const DELIVERED  = 5;

    const COMPLETED_FILTER = "completed";
    const PENDING_FILTER   = "pending";

    protected $fillable = [
        "user_id","address_id","shipping_cost","delivery_id","order"
    ];

    protected $dates = ["created_at"];

    protected $total = 0;

    public function scopeSearch($query, $search) {
        return $query -> whereHas("user", function ($q) use ($search) {
            $q -> where("name", "like", "%{$search}%")
                -> orWhere("email", "like", "%{$search}%");
        });
    }

    public function getStatusStringAttribute() {
        switch ($this -> status) {
            case self::PENDING:
                return "Placed";
            case self::CONFIRMED:
                return "Confirmed";
            case self::PREPARING:
                return "Preparing";
            case self::ON_THE_WAY:
                return "On The Way";
            case self::RETURNED:
                return "Returned";
            case self::DELIVERED:
                return "Delivered";
        }
        return "";
    }

    public function scopeStatus($query, $status) {
        return $query -> where("status", $status);
    }

    public function scopeEarnings($query) {
        return $query
            -> selectRaw("orders.id, IFNULL(sum(total), 0) as total")
            -> leftJoin("payment_detailes", "orders.id", "=", "order_id")
            -> whereNotNull("payment_date");
    }

    public function user() {
        return $this -> belongsTo(User::class);
    }

    public function address() {
        return $this -> belongsTo(Address::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_products')->withPivot('quantity','price','regular_price')->withTimestamps();
    }

    public function paymentDetailes(){
        return $this->belongsToMany(Payment::class,'payment_detailes')->withPivot('total','notes','payment_date')->withTimestamps();
    }

    public function prepareOrderProducts($products){
        $items = [];
        foreach ($products as $product) {
            $price = $product->discounted_price;
            $this->total += ($price * $product->pivot->quantity);
            $items[$product->id] = [
                'quantity' => $product->pivot->quantity,
                'price' => $price,
                'regular_price' => $product -> price
            ];
        }
        return $items;

    }

    public function preparePaymentData($request){
        $data[$request->get('payment_id')] = [
                'notes' => $request->get('notes'),
                'total' => $this->total + $this->shipping_cost
            ];
        return $data;

    }

    public function delivery(){
        return $this -> belongsTo(Delivery::class );
    }
}

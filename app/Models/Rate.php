<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'product_id','rate','comment'
    ];

    public function product() {
        return $this ->belongsTo(Product::class );
    }

    public function user() {
        return $this ->belongsTo(User::class );
    }
}

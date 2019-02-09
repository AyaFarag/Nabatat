<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        "name",
        "price",
        "description",
        "quantity",
        "height",
        "width",
        "category_id",
    ];

    protected $dates = [
        "ended_at"
    ];

    public function scopeSearch($query, $search) {
        return $query -> where("name", "like", "%{$search}%");
    }

    public function scopeHasOffer($query) {
        return $query -> whereHas("offer", function ($q) {
            return $q -> where("ended_at", ">=", \Carbon\Carbon::now() -> toDateTimeString());
        });
    }

    public function scopeInStock($query) {
        return $query -> where("quantity", ">=", 1);
    }

    public function scopeOutStock($query) {
        return $query -> where("quantity", "<", 1);
    }

    public function category() {
        return $this -> belongsTo(Category::class ,"category_id");
    }

    public function offer() {
        return $this -> hasOne(Offer::class);
    }

    public function cart() {
        return $this -> hasMany(Cart::class );
    }

    public function rate() {
        return $this -> hasMany(Rate::class );
    }

    public function ratings() {
        return $this -> hasMany(Rate::class );
    }

    public function getImagesAttribute() {
        return $this -> media -> map(function ($image) {
            return $image -> getUrl();
        });
    }


    public function orders() {
        return $this -> belongsToMany(Order::class);
    }

    public function averageRating() {
        return $this->hasOne(Rate::class)
            ->selectRaw("AVG(rate) as aggregate, product_id")
            ->groupBy("product_id");
    }

    public function getAverageRatingAttribute() {
        if (!array_key_exists("averageRating", $this->relations))
            $this->load("averageRating");

        $relation = $this->getRelation("averageRating");

        return $relation ? $relation->aggregate : 0;
    }

    public function getDiscountedPriceAttribute() {
        if($this->offer && $this -> offer -> ended_at -> gt(\Carbon\Carbon::now())){
            return $this->price - ($this->offer->discount * $this->price);
        }
        return $this->price;
    }
}

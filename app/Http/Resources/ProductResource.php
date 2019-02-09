<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $images = [];

        foreach ($this -> media as $media) {
            $images[] = URL($media -> getUrl());
        }

        return [
            "id"            => $this -> id,
            "name"          => $this -> name,
            "regular_price" => $this -> price,
            "description"   => $this -> description,
            "category"      => new CategoryResource($this -> category),
            "quantity"      => $this -> quantity,
            "width"         => $this -> width,
            "height"        => $this -> height,
            "images"        => $images,
            "sale_price"    => $this -> discounted_price,
            "rating"        => (int) $this -> average_rating,
            "on_sale"       => !!$this -> offer
        ];
    }
}

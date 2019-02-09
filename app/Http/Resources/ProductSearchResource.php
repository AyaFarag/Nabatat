<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"            => $this -> id,
            "name"          => $this -> name,
            "regular_price" => $this -> price,
            "description"   => $this -> description,
            "quantity"      => $this -> quantity,
            "width"         => $this -> width,
            "height"        => $this -> height,
            "image"         => url($this -> getFirstMediaUrl("images")),
            "sale_price"    => $this -> offer ? $this -> price - $this -> offer -> discount : $this -> price,
            "on_sale"       => !!$this -> offer,
            "rating"        => (int) $this -> average_rating
        ];
    }
}

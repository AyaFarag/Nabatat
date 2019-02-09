<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"         => $this -> id,
            "name"       => $this -> name,
            "price"      => $this -> pivot -> regular_price,
            "quantity"   => $this -> pivot -> quantity,
            "images"     => $this -> images,
            "sale_price" => $this -> pivot -> price,
            "total"      => $this -> quantity * $this -> pivot -> price,
            "rating"     => (int) $this -> average_rating,
            "on_sale"    => $this -> pivot -> price !== $this -> pivot -> regular_price
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EditableOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"             => $this -> id,
            "payment_method" => new PaymentResource($this -> paymentDetailes->first()),
            "address"        => new AddressResource($this -> address),
            "notes"          => $this -> paymentDetailes->first()->pivot->notes,
            "shipping_cost"  => $this -> shipping_cost,
            "status_string"  => $this -> statusString,
            "status_code"    => $this -> status,
            "total"          => $this -> paymentDetailes->first()->pivot->total,
            "products"       => OrderProductResource::collection($this->products)
        ];
    }
}

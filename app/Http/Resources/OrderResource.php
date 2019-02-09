<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"             => $this -> id,
            "payment_method" => new PaymentResource($this -> paymentDetailes -> first()),
            "address"        => new AddressResource($this -> address),
            "shipping_cost"  => $this -> shipping_cost,
            "status_string"  => $this -> statusString,
            "status_code"    => $this -> status,
            "code"           => "#" . $this -> code,
            "total"          => $this -> paymentDetailes -> first() -> pivot -> total
        ];
    }
}

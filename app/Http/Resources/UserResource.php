<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "first_name"   => $this -> first_name,
            "last_name"    => $this -> last_name,
            "email"        => $this -> email,
            "activated"    => $this -> activated,
            "api_token"    => $this -> api_token,
            "device_token" => $this -> device_token,
            "phone"        => $this -> phones -> first() -> phone,
            "address"      => new AddressResource($this -> addresses[0])
        ];
    }
}

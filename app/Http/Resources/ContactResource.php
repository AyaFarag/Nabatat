<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'id' => $this -> id,
            'addresses' => $this -> addresses,
            'phone_numbers' => $this -> phones,
            'emails' => $this -> emails,
            'social_networks' => $this-> social_networks,
        ];
    }
}

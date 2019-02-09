<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			"id"         => $this -> id,
			"first_name" => $this -> first_name,
			"last_name"=> $this -> last_name,
			"city"    => new CityResource($this -> city),
			"country" => (new CountryResource($this -> city -> country)) -> only("id", "name"),
			"phone"      => $this -> phone,
			"address"  => $this -> address
		];
	}
}

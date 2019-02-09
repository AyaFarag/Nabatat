<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"       => $this->id,
            "lat"      => $this->lat,
            "lang"     => $this->lang,
            "size"     => $this->size,
            "images"   => $this->images,
            "services" => ServiceResource::collection($this -> services)
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

class ServiceRequestRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "lat"           => "required",
            "lang"          => "required",
            "service_ids"   => "required|array",
            "service_ids.*" => "required|exists:services,id",
            "size"          => "required",
            'images'        => 'required|max:5|array',
            "address"       => "required"
        ];
    }

    public function requestAttributes() {
        return [
            "lat",
            "lang",
            "service_ids",
            "size",
            "images",
            "address"
        ];
    }
}

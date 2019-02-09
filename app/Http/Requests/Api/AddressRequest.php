<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

class AddressRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name"  => "required",
            "phone"      => "required|regex:/^\+?[0-9]{5,}$/",
            "address"    => "required|string",
            "city_id"    => "required|exists:cities,id"
        ];
    }

    public function requestAttributes() {
        return [
            "first_name",
            "last_name",
            "phone",
            "address",
            "city_id"
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

class RegisterRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "first_name"   => "required",
            "last_name"    => "required",
            "email"        => "required|email|unique:users",
            "password"     => "required|min:8|confirmed",
            "phone"        => "required|regex:/^\+?[0-9]{5,}$/|unique:users_phones",
            "city_id"      => "required|exists:cities,id",
            "address"      => "required",
            "device_token" => "nullable"
        ];
    }

    public function requestAttributes() {
        return [
            "first_name",
            "last_name",
            "email",
            "password",
            "phone",
            "city_id",
            "address",
            "device_token"
        ];
    }
}

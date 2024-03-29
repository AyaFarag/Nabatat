<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

class LoginRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "login"        => "required",
            "password"     => "required",
            "device_token" => "nullable"
        ];
    }

    public function requestAttributes() {
        return [
            "login",
            "password",
            "device_token"
        ];
    }
}

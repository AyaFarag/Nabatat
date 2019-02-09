<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this -> isMethod("post")) {
            return [
                "name"                => "required|min:3",
                "email"               => "required|email|unique:users",
                "password"            => "required|min:6|confirmed",
                "phones"              => "required|array",
                "phones.*"            => "unique:users_phones,phone",
                "addresses"           => "required|array",
                "addresses.*.city_id" => "exists:cities,id",
                "addresses.*.address" => "string",
                "activated"           => "nullable"
            ];
        }

        return [
            "name"                => "required|min:3",
            "email"               => "required|email|unique:users,email," . $this -> user -> id,
            "password"            => "nullable|min:6|confirmed",
            "phones"              => "required|array|min:1",
            "phones.*"            => [
                "required",
                Rule::unique("users_phones", "phone")
                    -> where(function ($query) {
                        return $query -> where("user_id", "!=", $this -> user -> id);
                    })
            ],
            "addresses"           => "required|array|min:1",
            "addresses.*"         => "required",
            "addresses.*.city_id" => "required|exists:cities,id",
            "addresses.*.address" => "required|string",
            "activated"           => "nullable"
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

class ResetPasswordRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "login"    => "required",
            "password" => "required|min:6|confirmed"
        ];
    }

    public function requestAttributes() {
        return [
            "login",
            "password"
        ];
    }
}

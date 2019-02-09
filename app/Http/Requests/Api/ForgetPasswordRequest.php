<?php

namespace App\Http\Requests\Api;

class ForgetPasswordRequest extends AbstractRequest
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
            "login" => "required",
            "code"  => "required|regex:/^[0-9]{4}$/"
        ];
    }

    public function requestAttributes() {
        return [
            "login",
            "code"
        ];
    }
}

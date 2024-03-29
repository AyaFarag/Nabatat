<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

class OrderProductRequest extends AbstractRequest
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
            "product_id" => "required|exists:products,id",
            "quantity"   => "required|numeric|min:1"
        ];
    }

    public function requestAttributes() {
        return [
            "product_id",
            "quantity"
        ];
    }
}

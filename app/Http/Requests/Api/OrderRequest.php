<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

class OrderRequest extends AbstractRequest
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
            'address_id' => 'required|exists:addresses,id',
            'payment_id' => 'required|exists:payments,id',
        ];
    }

    public function requestAttributes() {
        return [
            'address_id',
            'payment_id'
        ];
    }
}

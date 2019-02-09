<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\AbstractRequest;

use Illuminate\Validation\Rule;

class RateRequest extends AbstractRequest
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
            "rate" => "required|max:5|min:1",
            "comment" => "nullable|string",
        ];
    }
    public function requestAttributes() {
        return [
            "rate",
            "product_id",
            "comment"
        ];
    }
}

<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "orders" => 'required|array',
            "orders.*.product_variant_id" => "required|integer",
            "orders.*.quantity" => "required|integer|min:1|max:40",
            "address" => "required|regex:/([- ,\/0-9a-zA-Z]+)/"
        ];
    }
}

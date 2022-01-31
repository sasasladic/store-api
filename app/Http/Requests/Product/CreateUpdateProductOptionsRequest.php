<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CreateUpdateProductOptionsRequest extends FormRequest
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
        if (Route::is('productOptions.update')) {
            return $this->updateRules();
        }
        return [
            'attributes' => 'required|array',
            'attributes.*.attributes_data' => 'required|array',
            'attributes.*.attributes_data.id' => 'required|integer',
            'attributes.*.attributes_data.name' => 'required|string',
        ];
    }

    private function updateRules()
    {
        return [
            'variant_data.id' => 'required|integer',
            'variant_data.sku' => 'required|min:2|max:10',
            'variant_data.price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'variant_data.in_stock' => 'required|integer',
            'variant_values' => 'required|array',
            'variant_values.*.option_id' => 'required|integer',
            'variant_values.*.value' => 'required|string',
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CreateUpdateProductVariantRequest extends FormRequest
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
        if (Route::is('productVariant.update')) {
            return $this->updateRules();
        }
        return [
            'variants' => 'required|array',
            'variants.*.variant_data.sku' => 'required|unique:product_variants,sku|min:2|max:10',//Most important, so there is no duplications
            'variants.*.variant_data.price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'variants.*.variant_data.in_stock' => 'required|integer',
            'variants.*.variant_values' => 'required|array',
            'variants.*.variant_values.*.option_id' => 'required|integer',
            'variants.*.variant_values.*.value' => 'required|string',
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

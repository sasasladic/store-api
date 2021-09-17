<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CreateUpdateRequest extends FormRequest
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
            'name.*' => 'required|unique_translation:products|string|min:3|max:30',
            'description.*' => 'string|min:6|max:250',
            'active' => 'boolean',
            'category_id' => 'nullable|integer'
        ];
    }
}
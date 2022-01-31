<?php

namespace App\Http\Requests\Option;

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
            'name' => 'required|unique:options,name|string|min:3|max:50',
            'values' => 'required|array',
            'values.*.value' => 'required|string|min:1|max:10'
        ];
    }
}

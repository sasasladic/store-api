<?php

namespace App\Http\Requests\User;

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
        if (Route::is('user.update')){
            return [
                'name' => 'string|min:3|max:30',
                'email' => 'email|min:3|max:30',
                'password' => 'string|min:4|max:30',
                'active' => 'boolean',
                'role_id' => 'integer'
            ];
        }
        return [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|min:3|max:30',
            'password' => 'required|string|min:4|max:30',
            'active' => 'required|boolean',
            'role_id' => 'required|integer'
        ];
    }
}

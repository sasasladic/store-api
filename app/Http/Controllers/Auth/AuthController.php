<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            /** @var User $user */
            $user = Auth::user();
            if (Route::is('admin.login') && !in_array($user->role->id, Role::ADMINS)) {
                return $this->returnAccessForbidden();
            }

            $data = [
                'token' => $user->createToken('authToken')->plainTextToken,
                'name' => $user->name
            ];

            return $this->returnResponseSuccess($data, __('auth.success'));
        } else {
            return $this->returnResponseError(['error' => 'Unauthorised'], __('auth.failed'));
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();

        $data = array(
            'email' => $user->email,
            'role' => $user->role->name
        );

        return $this->returnResponseSuccess($data, __('OK'));
    }
}

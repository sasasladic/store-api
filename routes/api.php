<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::post('register', [AuthController::class, 'register'])->name('api.register');

Route::group(['namespace' => 'API'], function () {
    Route::group(['prefix' => 'category'], function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::get('tree', [CategoryController::class, 'tree']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('', [ProductController::class, 'index']);
        Route::get('/{product}', [ProductController::class, 'show']);
    });
});



Route::group([ 'middleware' => ['auth:api']], function () {
    Route::get('me', [AuthController::class, 'me']);
});



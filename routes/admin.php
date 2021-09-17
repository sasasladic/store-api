<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserOrderController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin panel API Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::get('test', function () {
    return 123;
});

Route::group([ 'middleware' => ['auth:api']], function () {

    Route::get('me', [AuthController::class, 'me']);

    Route::group(['namespace' => 'Admin'], function () {

        Route::group(['prefix' => 'category'], function () {
            Route::get('', [CategoryController::class, 'index']);

            Route::get('create', [CategoryController::class, 'create']);
            Route::post('create', [CategoryController::class, 'store'])->name('category.create');

            Route::get('{id}/edit', [CategoryController::class, 'edit']);
            Route::patch('{id}/edit', [CategoryController::class, 'update'])->name('category.update');

            Route::delete('{id}', [CategoryController::class, 'destroy']);
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('', [ProductController::class, 'allProducts']);
            Route::get('variants', [ProductController::class, 'allProductVariants']);

            Route::get('create', [ProductController::class, 'createProduct']);
            Route::post('create', [ProductController::class, 'storeProduct'])->name('product.store');

            //Route::get('{id}/edit', [ProductController::class, 'editProduct']); @TODO TODO
            Route::post('{id}/edit', [ProductController::class, 'updateProduct'])->name('product.update');

            Route::group(['prefix' => '{id}/variant'], function () {
                Route::post('create', [ProductController::class, 'storeProductVariants'])->name('productVariants.store');

                Route::get('', [ProductController::class, 'editProductVariants']);
                Route::patch('{variantId}/edit', [ProductController::class, 'updateProductVariant'])->name('productVariant.update');

                Route::delete('{variantId}', [ProductController::class, 'deleteProductVariant']);
            });



        });

        Route::group(['prefix' => 'option'], function () {
            Route::get('', [OptionController::class, 'allOptions']);
            Route::get('values', [OptionController::class, 'allOptionValues']);

            Route::get('select', [OptionController::class, 'allOptionsSelect']);
            Route::get('values/select', [OptionController::class, 'allOptionValuesSelect']);
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('', [UserOrderController::class, 'index']);
        });

//        Route::group(['prefix' => 'user'], function () {
//            Route::get('', [UserController::class, 'index']);
//        });


    });

    Route::resources(
        [
            'user' => UserController::class
        ]
    );
});



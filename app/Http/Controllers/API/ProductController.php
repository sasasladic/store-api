<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Http\Resources\API\Product\Item\ShowProductResource;
use App\Http\Resources\API\Product\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $allProducts = $this->productRepository->getAll();
        if ($allProducts) {
            return $this->returnResponseSuccessWithPagination(
                ProductResource::collection($allProducts),
                __('cruds.success.list', ['data' => 'products'])
            );
        }
        return $this->returnResponseError([], 'No categories found');

    }

    public function show(Product $product)
    {
        $productAttributes = OptionSearchResource::collection($product->options);

        return $this->returnResponseSuccess(
            new ShowProductResource($product),
            __('cruds.success.edit', ['model' => 'Product']),
            ['attributes' => $productAttributes]
        );
    }
}

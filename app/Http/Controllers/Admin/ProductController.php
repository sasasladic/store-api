<?php

namespace App\Http\Controllers\Admin;

use App\Helper\TranslationHelper;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\CreateUpdateProductVariantRequest;
use App\Http\Requests\Product\CreateUpdateRequest;
use App\Http\Resources\Admin\Category\Item\CreateCategoryItem;
use App\Http\Resources\Admin\Category\Model\CategoryCreate;
use App\Http\Resources\Admin\Category\Resources\CategoryResource;
use App\Http\Resources\Admin\Product\Resources\ProductResource;
use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;

class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    private ProductService $productService;

    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param ProductService $productService
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductService $productService
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allProducts()
    {
        $allProducts = $this->productRepository->index(Product::class, ['category']);

        return $this->returnResponseSuccessWithPagination(
            ProductResource::collection($allProducts),
            __('cruds.success.list', ['data' => 'products'])
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createProduct()
    {
        //It's the same as for categories (for now)
        return $this->returnResponseSuccess(
            new CreateCategoryItem(
                new CategoryCreate(
                    TranslationHelper::getLanguagesCollection(),
                    CategoryResource::collection(Category::withoutGlobalScopes()->orderByDesc('id')->take(10)->get())
                )
            ),
            __('cruds.success.create')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProduct(CreateUpdateRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            return $this->returnResponseSuccess(['product_id' => $product->id], __('cruds.success.stored'));
        }catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProduct(CreateUpdateRequest $request, int $id)
    {
        try {
            $this->productRepository->update(app(Product::class)->getTable(), $id, $request->validated(), $request->user());

            return $this->returnResponseSuccess(['product_id' => $id],  __('cruds.success.updated', ['model' => 'Product']));
        }catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUpdateProductVariantRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProductVariants(CreateUpdateProductVariantRequest $request, int $id)
    {
        $product = $this->productRepository->findWithoutGlobalScopes(Product::class, $id);
        if (!$product) {
            return $this->returnNotFoundError();
        }

        $data = $request->validated();
        foreach ($data['variants'] as $variant) {
            $optionValues = $this->productService->getRequestVariantOptionValues($variant['variant_values'], $id, $request->user()->id);
            //PRODUCT VARIANTS
            $variant['variant_data']['product_id'] = $id;
            $productVariant = ProductVariant::create($variant['variant_data']);
            //VARIANT VALUES
            $productVariant->optionValues()->sync($optionValues, false);
        }

        return $this->returnResponseSuccess([], __('cruds.success.stored'));

    }

    public function editProductVariants(int $productId)
    {
        $productVariants = $this->productRepository->getAllProductVariants($productId);

        return $this->returnResponseSuccessWithPagination(
            ProductVariantsResource::collection($productVariants),
            __('cruds.success.list', ['data' => 'products'])
        );


    }

    /**
     * @param CreateUpdateProductVariantRequest $request
     * @param int $id
     * @param int $variantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductVariant(CreateUpdateProductVariantRequest $request, int $id, int $variantId){
        $product = $this->productRepository->findWithoutGlobalScopes(Product::class, $id);
        if (!$product) {
            return $this->returnNotFoundError();
        }

        $productVariant = $this->productRepository->findWithoutGlobalScopes(ProductVariant::class, $variantId);

        $data = $request->validated();
        $optionValues = $this->productService->getRequestVariantOptionValues($data['variant_values'], $id, $request->user()->id);

        //VARIANT VALUES SYNC
        $productVariant->optionValues()->sync($optionValues, true);
        //UPDATE PRODUCT VARIANT
        $productVariant->update($data['variant_data']);

        return $this->returnResponseSuccess(['product_id' => $product->id],  __('cruds.success.updated', ['model' => 'Product Variants']));

    }

    public function deleteProductVariant(int $variantId)
    {
        $deleted = $this->productRepository->delete(app(ProductVariant::class)->getTable(), $variantId);
        if ($deleted) {
            return $this->returnResponseSuccess([],  __('cruds.success.deleted', ['model' => 'Product Variant']));
        }

        return $this->returnResponseError([],  __('cruds.error.deleted', ['model' => 'Product Variant']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ImageHelper;
use App\Helper\TranslationHelper;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\CreateUpdateProductOptionsRequest;
use App\Http\Requests\Product\CreateUpdateProductVariantRequest;
use App\Http\Requests\Product\CreateUpdateRequest;
use App\Http\Resources\Admin\Category\Item\CreateCategoryItem;
use App\Http\Resources\Admin\Category\Model\CategoryCreate;
use App\Http\Resources\Admin\Category\Resources\CategoryResource;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductResource;
use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Models\Category;
use App\Models\CategoryGender;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    private ProductService $productService;

    private CategoryRepositoryInterface $categoryRepository;

    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param ProductService $productService
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductService $productService,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allProducts()
    {
//        $allProducts = $this->productRepository->index(Product::class, ['categoryGender']);
        $allProducts = $this->productRepository->adminGetAll();

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
        $allCategories = $this->categoryRepository->getAll(false);

        //It's the same as for categories (for now)
        return $this->returnResponseSuccess(
            new CreateCategoryItem(
                new CategoryCreate(
                    TranslationHelper::getLanguagesCollection(),
                    CategoryResource::collection($allCategories)
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
            $author = $request->user();
            $validatedData = $request->validated();
            if ($validatedData['images']) {
                unset($validatedData['images']);
            }

            $categoryGender = CategoryGender::where('category_id', $validatedData['category_id'])->where('gender_id', $validatedData['gender'])->first();
            $validatedData['category_gender_id'] = $categoryGender->id;

            unset($validatedData['category_id']);
            unset($validatedData['gender_id']);

            $product = Product::create($validatedData);

            $productImages = [];
            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = "product/$product->id/" . Str::random(8) . "_" . strtolower($image->getClientOriginalName());
                    //PATH SHOULD BE FULL PATH WITH IMAGE NAME
                    ImageHelper::uploadImage($imagePath, $image->getContent());
                    $productImages[] = [
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'created_by' => $author->id,
                        'updated_by' => $author->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            if ($productImages) {
                DB::table('product_images')->insert($productImages);
            }

            return $this->returnResponseSuccess(['product_id' => $product->id], __('cruds.success.stored'));
        } catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editProduct($id)
    {
        $product = $this->productRepository->findWithoutGlobalScopes(Product::class, $id);
        if (!$product) {
            return $this->returnNotFoundError();
        }

        return $this->returnResponseSuccessWithPagination(
            new ProductResource($product),
            __('cruds.success.list', ['data' => 'products'])
        );
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
            $this->productRepository->update(
                app(Product::class)->getTable(),
                $id,
                $request->validated(),
                $request->user()
            );

            return $this->returnResponseSuccess(
                ['product_id' => $id],
                __('cruds.success.updated', ['model' => 'Product'])
            );
        } catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    public function storeProductOptions(CreateUpdateProductOptionsRequest $request, int $id)
    {
        $product = $this->productRepository->findWithoutGlobalScopes(Product::class, $id);
        if (!$product) {
            return $this->returnNotFoundError();
        }

        $validatedData = $request->validated();
        if (!$validatedData['attributes']) {
            return $this->returnResponseError([], __('cruds.errors.empty_array'));
        }
        $attributeIds = [];
        foreach ($validatedData['attributes'] as $attribute) {
            $attributeIds[] = $attribute['attributes_data']['id'];
        }
        $attributeIds = array_unique($attributeIds);

        try {
            $product->options()->attach($attributeIds);

            return $this->returnResponseSuccess([], __('cruds.success.stored'));
        } catch (\Exception $exception) {
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
            $optionValues = $this->productService->getRequestVariantOptionValues(
                $variant['variant_values'],
                $id,
                $request->user()->id
            );
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

        $product = $this->productRepository->findWithoutGlobalScopes(Product::class, $productId);
        $productAttributes = OptionSearchResource::collection($product->options);


        return $this->returnResponseSuccessWithPagination(
            ProductVariantsResource::collection($productVariants),
            __('cruds.success.list', ['data' => 'products']),
            ['attributes' => $productAttributes]
        );
    }

    public function editProductVariant(int $variantId)
    {
        $productVariant = $this->productRepository->findWithoutGlobalScopes(ProductVariant::class, $variantId);


        return $this->returnResponseSuccessWithPagination(
            new ProductVariantsResource($productVariant),
            __('cruds.success.list', ['data' => 'products'])
        );
    }

    /**
     * @param CreateUpdateProductVariantRequest $request
     * @param int $id
     * @param int $variantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductVariant(CreateUpdateProductVariantRequest $request, int $id, int $variantId)
    {
        $product = $this->productRepository->findWithoutGlobalScopes(Product::class, $id);
        if (!$product) {
            return $this->returnNotFoundError();
        }

        $productVariant = $this->productRepository->findWithoutGlobalScopes(ProductVariant::class, $variantId);

        $data = $request->validated();
        $optionValues = $this->productService->getRequestVariantOptionValues(
            $data['variant_values'],
            $id,
            $request->user()->id
        );

        //VARIANT VALUES SYNC
        $productVariant->optionValues()->sync($optionValues, true);
        //UPDATE PRODUCT VARIANT
        $productVariant->update($data['variant_data']);

        return $this->returnResponseSuccess(
            ['product_id' => $product->id],
            __('cruds.success.updated', ['model' => 'Product Variants'])
        );
    }

    public function deleteProductVariant(int $variantId)
    {
        $deleted = $this->productRepository->delete(app(ProductVariant::class)->getTable(), $variantId);
        if ($deleted) {
            return $this->returnResponseSuccess([], __('cruds.success.deleted', ['model' => 'Product Variant']));
        }

        return $this->returnResponseError([], __('cruds.error.deleted', ['model' => 'Product Variant']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct($id)
    {
        //
    }
}

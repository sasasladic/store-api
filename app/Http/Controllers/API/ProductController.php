<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Http\Resources\API\Product\Item\ListProductResource;
use App\Http\Resources\API\Product\Item\ShowProductItem;
use App\Http\Resources\API\Product\Item\ShowProductResource;
use App\Http\Resources\API\Product\Model\ListObject;
use App\Http\Resources\API\Product\Model\ShowProduct;
use App\Http\Resources\API\Product\ProductResource;
use App\Models\CategoryGender;
use App\Models\Product;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    private CategoryService $categoryService;

    private BaseRepositoryInterface $baseRepository;

    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryService $categoryService
     * @param BaseRepositoryInterface $baseRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository, CategoryService $categoryService, BaseRepositoryInterface $baseRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
        $this->baseRepository = $baseRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categoryGenderIds = [];
        if ($request->get('category_gender_id')) {
            $categoryGender = $this->baseRepository->findById(CategoryGender::class, $request->get('category_gender_id'), ['category', 'category.children']);
            $categoryGenderIds = $this->categoryService->findCategoryGenderSubcategories($categoryGender);
        }
        $allProducts = $this->productRepository->getAll($categoryGenderIds);
        $category = isset($categoryGender) ? $categoryGender->category : null;
        if ($allProducts) {
            return $this->returnResponseSuccessWithPagination(
                new ListProductResource(
                    new ListObject($category, $allProducts)
                ),
                __('cruds.success.list', ['data' => 'products'])
            );
        }
        return $this->returnResponseError([], 'No categories found');
    }

    public function show(Product $product)
    {
        //Attributes to Show
        $productAttributes = OptionSearchResource::collection($product->options);
        $productVariants = $this->productRepository->getAllProductVariants($product->id);

        return $this->returnResponseSuccess(
            new ShowProductItem(new ShowProduct($product, $productVariants, $productAttributes)),
            __('cruds.success.edit', ['model' => 'Product'])
        );
    }
}

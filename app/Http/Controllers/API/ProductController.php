<?php

namespace App\Http\Controllers\API;

use App\Helper\PaginationHelper;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Http\Resources\API\Category\SelectCategoryResource;
use App\Http\Resources\API\Product\Item\ListProductResource;
use App\Http\Resources\API\Product\Item\ShowProductItem;
use App\Http\Resources\API\Product\Item\ShowProductResource;
use App\Http\Resources\API\Product\Model\ListObject;
use App\Http\Resources\API\Product\Model\ShowProduct;
use App\Http\Resources\API\Product\ProductResource;
use App\Models\CategoryGender;
use App\Models\Product;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    private CategoryService $categoryService;

    private BaseRepositoryInterface $baseRepository;

    private CategoryRepositoryInterface $categoryRepository;


    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryService $categoryService
     * @param BaseRepositoryInterface $baseRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryService $categoryService,
        BaseRepositoryInterface $baseRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
        $this->baseRepository = $baseRepository;
        $this->categoryRepository = $categoryRepository;
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

        $filters = [];
        $allProducts = $allProducts->filter(function($item) use (&$filters, $request) {
            $return = false;
            foreach ($item->activeVariants as $variant) {
                $color = $request->get('color') ? false : null;
                $size = $request->get('size') ? false : null;
                $noFilter = is_null($color) && is_null($size);
                foreach ($variant->optionValues as $optionValue) {
                    if (isset($filters[$optionValue->option->name])) {
                        if (!in_array($optionValue->value, $filters[$optionValue->option->name])) {
                            $filters[$optionValue->option->name][] = $optionValue->value;
                        }
                    }else{
                        $filters[$optionValue->option->name][] = $optionValue->value;
                    }

                    if ($noFilter) {
                        continue;
                    }
                    if ($optionValue->option->name == 'Color' && $request->get('color')) {
                        if (in_array($optionValue->value, $request->get('color'))) {
                            $color = true;
                        }
                    }
                    if ($optionValue->option->name == 'Size' && $request->get('size')) {
                        if (in_array($optionValue->value, $request->get('size'))) {
                            $size = true;
                        }
                    }
                }
                if ($noFilter) {
                    $return = true;
                }else{
                    if (!$return) {
                        if (!count($variant->optionValues) == 0) {
                            $return = $color || $size;
//                            if (!is_null($color) && !is_null($size)) {
//                                $return = $color && $size;
//                            }
//                            if (!is_null($color) && is_null($size)) {
//                                $return = $color;
//                            }
//                            if (is_null($color) && !is_null($size)) {
//                                $return = $size;
//                            }
                        }
                    }
                }
            }
            return $return;
        });

        if (!$request->get('category_gender_id')) {
            $allCategories = $this->categoryRepository->getAll(false, false);
            $filters['categories'] = SelectCategoryResource::collection($allCategories);
        }
        $paginated = PaginationHelper::paginate($allProducts, 10);

        if ($paginated) {
            return $this->returnResponseSuccessWithPagination(
                new ListProductResource(
                    new ListObject($category, $paginated, $filters)
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

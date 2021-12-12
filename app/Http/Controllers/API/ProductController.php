<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Http\Resources\API\Product\Item\ListProductResource;
use App\Http\Resources\API\Product\Item\ShowProductResource;
use App\Http\Resources\API\Product\Model\ListObject;
use App\Http\Resources\API\Product\ProductResource;
use App\Models\CategoryGender;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

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
    public function index(Request $request)
    {
        $categoryGenderIds = [];
        if ($request->get('category_gender_id')) {
            $categoryGender = QueryBuilder::for(CategoryGender::class)
                ->with(['category', 'category.children'])
                ->where('id', $request->get('category_gender_id'))
                ->first();
            $categoryGenderIds = [$categoryGender->id];

            foreach ($categoryGender->category->children as $category) {
                $categoryGenderItem = $category->checkBelongsToGender($categoryGender->gender_id);
                if ($categoryGenderItem) {
                    $categoryGenderIds[] = $categoryGenderItem->pivot->id;
                }
            }
        }
        $allProducts = $this->productRepository->getAll($categoryGenderIds);
        $category = $categoryGender ? $categoryGender->category : null;
        if ($allProducts) {
            return $this->returnResponseSuccessWithPagination(
                new ListProductResource(
                    new ListObject($category, $allProducts)),
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

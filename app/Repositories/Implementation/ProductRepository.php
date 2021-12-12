<?php

namespace App\Repositories\Implementation;

use App\Models\Category;
use App\Models\CategoryGender;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use App\Repositories\OptionValueRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    private OptionValueRepositoryInterface $optionRepository;

    /**
     * CategoryController constructor.
     * @param OptionValueRepositoryInterface $optionRepository
     */
    public function __construct(OptionValueRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function createProductOptionRelation(int $productId, $optionId, $userId)
    {
        $productOption = $this->getProductOptionByIds($productId, $optionId);

        if (!$productOption) {
            $productOption = ProductOption::create(
                [
                    'product_id' => $productId,
                    'option_id' => $optionId,
                    'created_by' => $userId,
                    'updated_by' => $userId
                ]
            );
        }

        return $productOption;
    }

    public function getProductOptionByIds(int $productId, int $optionId)
    {
        return ProductOption::where('product_id', $productId)->where('option_id', $optionId)->first();
    }

    public function getAllProductVariants(int $productId)
    {
        return QueryBuilder::for(ProductVariant::class)
            ->where('product_id', $productId)
            ->with(['optionValues', 'optionValues.option'])
            ->allowedFilters(
                [
                    'id',
                    'sku',
                    AllowedFilter::exact('optionValues.option.name'),
                    AllowedFilter::exact('optionValues.value'),
                ]
            )
            ->withoutGlobalScopes() // Soft delete is a global scope
            ->paginate(config('admin-panel.pagination.default'));
    }

    public function getAll($limit = 0)
    {
        $categoryGenderIds = [];
        if (request()->get('category_gender_id')) {
            $categoryGender = QueryBuilder::for(CategoryGender::class)
                ->with(['category', 'category.children'])
                ->where('id', request()->get('category_gender_id'))
                ->first();
            $categoryGenderIds = [$categoryGender->id];

            foreach ($categoryGender->category->children as $category) {
                $categoryGenderItem = $category->checkBelongsToGender($categoryGender->gender_id);
                if ($categoryGenderItem) {
                    $categoryGenderIds[] = $categoryGenderItem->pivot->id;
                }
            }
        }

        $query = QueryBuilder::for(Product::class)
            ->select('products.*')
            ->join('category_gender', 'products.category_gender_id', 'category_gender.id')
            ->join('genders', 'category_gender.gender_id', 'genders.id')
            ->join('categories', 'category_gender.category_id', 'categories.id')
            ->with(['images', 'categoryGender', 'categoryGender.category'])
            ->allowedFilters(
                [
                    'name',
                    AllowedFilter::exact('genders.gender'),
                    'categories.name',
                ]
            );

        if ($categoryGenderIds) {
            $query->whereIn('category_gender_id', $categoryGenderIds);
        }

        $query->withoutGlobalScopes(); // Soft delete is a global scope;

        if ($limit > 0) {
            return $query->take($limit)->get();
        }

        return $query->paginate(config('api.pagination.product.index'));
    }
}

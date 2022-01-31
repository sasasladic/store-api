<?php

namespace App\Repositories\Implementation;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use App\QueryBuilder\Filters\Product\FilterPrice;
use App\QueryBuilder\Filters\Product\FilterSearchTerm;
use App\Repositories\OptionValueRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
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

    public function getAll(array $categoryGenderIds = [], $limit = 0)
    {
        $query = QueryBuilder::for(Product::class)
            ->select('products.*', 'variants.lowest')
            ->join('category_gender', 'products.category_gender_id', 'category_gender.id')
            ->join('genders', 'category_gender.gender_id', 'genders.id')
            ->join('categories', 'category_gender.category_id', 'categories.id')
            ->uniquePrice()
            ->join('product_variants', 'product_variants.product_id', 'products.id')
            ->distinct()
            ->with(['images', 'categoryGender', 'categoryGender.category', 'activeVariants.optionValues']) //maybe remove activeVariants.optionValues
            ->whereHas('activeVariants')
            ->allowedFilters(
                [
                    'name',
                    AllowedFilter::exact('gender','genders.gender'),
                    AllowedFilter::partial('category','categories.name'),
                    AllowedFilter::custom('searchTerm', new FilterSearchTerm()),
                    AllowedFilter::custom('price_between', new FilterPrice())
                ]
            );

        if ($categoryGenderIds) {
            $query->whereIn('category_gender_id', $categoryGenderIds);
        }

//        $query->withoutGlobalScopes(); // Soft delete is a global scope;
        $query->allowedSorts(
            AllowedSort::field('oldest', 'products.created_at'),
            AllowedSort::field('price', 'variants.lowest'),
        );
        if ($limit > 0) {
//            return $query->take($limit)->get();
        }
        return $query->get();
//        return $query->paginate(config('api.pagination.product.index'));
    }

    public function adminGetAll()
    {
        $query = QueryBuilder::for(Product::class)
            ->select('products.*')
            ->join('category_gender', 'products.category_gender_id', 'category_gender.id')
            ->join('categories', 'category_gender.category_id', 'categories.id')
            ->with(['categoryGender']) //maybe remove activeVariants.optionValues
            ->allowedFilters(
                [
//                    'name',
//                    'id',
//                    AllowedFilter::exact('gender','genders.gender'),
//                    AllowedFilter::partial('category','categories.name'),
                    AllowedFilter::custom('searchTerm', new FilterSearchTerm()),
//                    AllowedFilter::custom('price_between', new FilterPrice())
                ]
            );
        $query->withoutGlobalScopes() // Soft delete is a global scope;
        ->allowedSorts(
            AllowedSort::field('oldest', 'products.created_at'),
            AllowedSort::field('price', 'variants.lowest'),
        );

        return $query->paginate(config('api.pagination.product.index'));
    }

}

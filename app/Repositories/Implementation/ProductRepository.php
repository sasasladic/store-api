<?php

namespace App\Repositories\Implementation;

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

    public function getAll()
    {
        return QueryBuilder::for(Product::class)
            ->allowedFilters(
                [
                    'name',
                ]
            )
            ->withoutGlobalScopes() // Soft delete is a global scope
            ->paginate(config('api.pagination.product.index'));
    }
}

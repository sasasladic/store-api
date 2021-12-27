<?php


namespace App\QueryBuilder\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterPrice implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $q) use ($value) {
            $q->where('product_variants.price', '>=', $value[0])
                ->where('product_variants.price', '<=', $value[1]);
        });
    }
}

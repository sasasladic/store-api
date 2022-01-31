<?php


namespace App\QueryBuilder\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterSearchTerm implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $q) use ($value) {
            $q->where('products.name', 'LIKE', '%' . $value . '%')
                ->orWhere('categories.name', 'LIKE', '%' . $value . '%')
                ->orWhere('products.id', $value);
        });
    }
}

<?php

namespace App\Repositories\Implementation;

use App\Models\Option;
use App\Models\OptionValue;
use App\Repositories\OptionValueRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class OptionValueRepository extends BaseRepository implements OptionValueRepositoryInterface
{
    public function getAll()
    {
        return QueryBuilder::for(Option::class)
            ->allowedFilters(
                [
                    'name',
                ]
            )
            ->with('values')
            ->allowedSorts('name')
            ->withoutGlobalScopes() // Soft delete is a global scope
            ->paginate(config('admin-panel.pagination.default'));
    }

    public function getAllValues()
    {
        return QueryBuilder::for(OptionValue::class)
            ->allowedFilters(
                [
                    'option.id',
                    'value',
                ]
            )
            ->allowedSorts('name')
            ->withoutGlobalScopes() // Soft delete is a global scope
            ->paginate(config('admin-panel.pagination.default'));
    }

    public function getOptionValueRelation(int $optionId, int $valueId)
    {
        return OptionValue::where('option_id', $optionId)->where('value', $valueId)->first();
    }
}

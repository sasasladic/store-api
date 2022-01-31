<?php

namespace App\Repositories\Implementation;

use App\Models\Category;
use App\Models\Gender;
use App\Repositories\CategoryRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getAll(bool $admin = true, $spatieFilter = true)
    {
        $queryBuilder = QueryBuilder::for(Category::class);

        if ($spatieFilter) {
            $queryBuilder->allowedFilters(['name'])->withoutGlobalScopes();
        }

        if ($admin) {
            return $queryBuilder
                ->defaultSort('-id')
                ->paginate(config('admin-panel.pagination.default'));
        }

        return $queryBuilder
            ->whereDoesntHave('children')
            ->defaultSort('-name')
//            ->paginate(config('api.pagination.category.index')); ako ne radi odk ovo
            ->get();
    }

    public function getTree()
    {
        //Depth  2
        return QueryBuilder::for(Gender::class)
            ->with(['categories'])
            ->allowedFilters(
                [
                    'categories.name',
                ]
            )
            ->get();
    }
}

<?php

namespace App\Repositories\Implementation;

use App\Models\Category;
use App\Models\CategoryGender;
use App\Models\Gender;
use App\Repositories\CategoryRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getAll(bool $admin = true)
    {
        $queryBuilder = QueryBuilder::for(Category::class)
//            ->with('parent')
            ->allowedFilters(
                [
                    'name',
                ]
            );

        if ($admin) {
            return $queryBuilder->withoutGlobalScopes()
                ->defaultSort('-id')
                ->paginate(config('admin-panel.pagination.default'));
        }

        return $queryBuilder
            ->whereDoesntHave('children')
            ->defaultSort('-name')
            ->paginate(config('api.pagination.category.index'));
    }

    public function getTree()
    {
//        dd(CategoryGender::with('category')->first());
        ray()->showQueries();
        return QueryBuilder::for(Gender::class)
            ->with(['categories', 'categories.children'])
            ->allowedFilters(
                [
                    'categories.name',
                ]
            )
//            ->defaultSort('-rootCategory.name')
            ->get();

//        return QueryBuilder::for(Category::class)
//            ->with('children')
//            ->allowedFilters(
//                [
//                    'name',
//                ]
//            )
//            ->whereNull('parent_id')
//            ->defaultSort('-name')
//            ->paginate(config('api.pagination.category.tree'));
    }
}

<?php

namespace App\Repositories\Implementation;

use App\Models\UserOrder;
use App\Repositories\UserOrderRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class UserOrderRepository extends BaseRepository implements UserOrderRepositoryInterface
{

    public function getAll()
    {
        return QueryBuilder::for(UserOrder::class)
            ->with(['productVariant', 'user'])
            ->allowedFilters(
                [
                    'productVariant.sku',
                    'user.id',
                    'user.name',
                    'user.email'
                ]
            )
            ->defaultSort('-id')
            ->paginate(config('admin-panel.pagination.default'));
    }
}

<?php

namespace App\Repositories\Implementation;

use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function getAll()
    {
        return QueryBuilder::for(Order::class)
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

    public function makeOrder(array $data)
    {
        return Order::create($data);
    }
}

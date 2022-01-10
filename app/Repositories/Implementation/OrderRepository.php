<?php

namespace App\Repositories\Implementation;

use App\Models\Order;
use App\QueryBuilder\Filters\Product\FilterPrice;
use App\Repositories\OrderRepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function getAll(int $userId = null)
    {
        $query = QueryBuilder::for(Order::class)
            ->with(['productVariant', 'user'])
            ->allowedFilters(
                [
                    'productVariant.sku',
                    AllowedFilter::exact('user', 'user.id'),
                    'user.name',
                    'user.email',
                    'created_at',
                    AllowedFilter::scope('created_between')
                ]
            );
        if ($userId) {
            $query->where('user_id', $userId);
        }
        return $query->defaultSort('-id')
            ->allowedSorts(
                'id',
                AllowedSort::field('last_updated', 'updated_at'),
                'sum',
            )
            ->paginate(config('admin-panel.pagination.default'));
    }

    public function makeOrder(array $data)
    {
        return Order::create($data);
    }
}

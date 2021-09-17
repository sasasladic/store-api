<?php

namespace App\Repositories\Implementation;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getAll()
    {
        return QueryBuilder::for(User::class)
            ->with('role')
            ->allowedFilters(
                [
                    'id',
                    'name',
                    'email',
                    'active',
                    'role.name'
                ]
            )
            ->defaultSort('-id')
            ->withoutGlobalScopes()
            ->paginate(config('admin-panel.pagination.default'));
    }
}

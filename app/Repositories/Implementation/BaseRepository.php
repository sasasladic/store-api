<?php

namespace App\Repositories\Implementation;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface
{

    public function index($model, array $with = [])
    {
        $query = $model::withoutGlobalScopes();
        if (!empty($with)) {
            $query->with($with);
        }

        return $query->paginate(config('admin-panel.pagination.default'));
    }

    public function store($model, array $data)
    {
        return $model::create($data);
    }

    public function update(string $table, int $id, array $data, User $user): int
    {
        return DB::table($table)->where('id', '=', $id)
            ->update(
                array_merge(
                    $data,
                    [
                        'updated_by' => $user->id,
                        'updated_at' => now()
                    ]
                )
            );
    }

    public function findWithoutGlobalScopes($model, int $id)
    {
        return $model::withoutGlobalScopes()->find($id);
    }

    public function findById($model, int $id, array $with = [])
    {
        $query = $model::where('id', $id);
        if (!empty($with)) {
            $query->with($with);
        }

        return $query->first();
    }

    public function softDelete(string $table, int $id, User $user, array $additionalFields = []): int
    {
        return DB::table($table)->where('id', '=', $id)
            ->update(
                array_merge(
                    [
                        'deleted_by' => $user->id,
                        'deleted_at' => now(),
                        'updated_by' => $user->id,
                        'updated_at' => now()
                    ],
                    $additionalFields
                )
            );
    }

    public function delete(string $table, int $id): bool
    {
        return DB::table($table)->delete($id);
    }
}

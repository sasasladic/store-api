<?php

namespace App\Repositories;

use App\Models\User;

interface BaseRepositoryInterface
{
    public function index($model, array $with = []);

    public function store($model, array $data);

    public function update(string $table, int $id, array $data, User $user): int;

    public function findWithoutGlobalScopes($model, int $id);

    public function findById($model, int $id, array $with = []);

    public function softDelete(string $table, int $id, User $user, array $additionalFields = []): int;

    public function delete(string $table, int $id): bool;

}

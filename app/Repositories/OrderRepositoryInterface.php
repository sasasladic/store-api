<?php

namespace App\Repositories;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll(int $userId = null);

    public function makeOrder(array $data);
}

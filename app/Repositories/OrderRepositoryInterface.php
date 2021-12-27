<?php

namespace App\Repositories;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll();

    public function makeOrder(array $data);
}

<?php

namespace App\Repositories;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll(bool $admin = true, $spatieFilter = true);

    public function getTree();
}

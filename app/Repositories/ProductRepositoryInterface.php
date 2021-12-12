<?php

namespace App\Repositories;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{

    public function createProductOptionRelation(int $productId, $optionId, $userId);

    public function getProductOptionByIds(int $productId, int $optionId);

    public function getAllProductVariants(int $productId);

    public function getAll(array $categoryGenderIds = [], int $limit = 0);
}

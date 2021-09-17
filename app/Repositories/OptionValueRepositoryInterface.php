<?php

namespace App\Repositories;

interface OptionValueRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll();

    public function getAllValues();

    public function getOptionValueRelation(int $optionId, int $valueId);
}

<?php

namespace App\Http\Resources\Admin\Product\Model;

class ProductVariantList
{
    private $attributes;

    private $productVariants;

    public function __construct($productVariants, $attributes)
    {
        $this->productVariants = $productVariants;
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getProductVariants()
    {
        return $this->productVariants;
    }
}

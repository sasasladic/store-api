<?php

namespace App\Http\Resources\API\Product\Model;

class ShowProduct
{
    private $variants;

    private $product;

    private $allOptions;

    /**
     * ShowProduct constructor.
     * @param $product
     * @param $variants
     * @param $allOptions
     */
    public function __construct($product, $variants, $allOptions)
    {
        $this->product = $product;
        $this->variants = $variants;
        $this->allOptions = $allOptions;
    }

    /**
     * @return mixed
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getAllOptions()
    {
        return $this->allOptions;
    }
}

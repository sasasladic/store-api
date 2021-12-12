<?php

namespace App\Http\Resources\API\Product\Model;

class ListObject
{
    private $category;

    private $products;

    /**
     * HomePageObject constructor.
     * @param $category
     * @param $products
     */
    public function __construct($category, $products)
    {
        $this->category = $category;
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }
}

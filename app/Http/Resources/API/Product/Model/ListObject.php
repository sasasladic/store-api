<?php

namespace App\Http\Resources\API\Product\Model;

class ListObject
{
    private $category;

    private $products;

    private $filters;

    /**
     * HomePageObject constructor.
     * @param $category
     * @param $products
     * @param $filters
     */
    public function __construct($category, $products, $filters)
    {
        $this->category = $category;
        $this->products = $products;
        $this->filters = $filters;
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

    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }
}

<?php

namespace App\Http\Resources\API\HomePage\Model;

class HomePageObject
{
    private $genders;

    private $products;

    /**
     * HomePageObject constructor.
     * @param $genders
     * @param $products
     */
    public function __construct($genders, $products)
    {
        $this->genders = $genders;
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getGenders()
    {
        return $this->genders;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }
}

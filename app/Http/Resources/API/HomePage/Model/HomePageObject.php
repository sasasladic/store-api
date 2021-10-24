<?php


namespace App\Http\Resources\API\HomePage\Model;


class HomePageObject
{
    private $geneders;

    private $products;

    /**
     * HomePageObject constructor.
     * @param $geneders
     * @param $products
     */
    public function __construct($geneders, $products)
    {
        $this->geneders = $geneders;
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getGeneders()
    {
        return $this->geneders;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }
}

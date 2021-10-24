<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\HomePage\Item\HomePageItem;
use App\Http\Resources\API\HomePage\Model\HomePageObject;
use App\Models\Gender;
use App\Repositories\ProductRepositoryInterface;

class HomePageController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        $genders = Gender::all();
        $products = $this->productRepository->getAll(5);

        return $this->returnResponseSuccess(
            new HomePageItem(
                new HomePageObject($genders, $products)
            ),
            'List of homepage objects'
        );
    }
}

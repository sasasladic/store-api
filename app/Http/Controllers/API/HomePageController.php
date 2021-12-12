<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\HomePage\Item\HomePageItem;
use App\Http\Resources\API\HomePage\Model\HomePageObject;
use App\Repositories\ProductRepositoryInterface;
use App\Services\CategoryService;

class HomePageController extends BaseController
{
    private ProductRepositoryInterface $productRepository;

    private CategoryService $categoryService;

    /**
     * CategoryController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryService $categoryService
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryService $categoryService
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
    }

    public function getAll()
    {
        $genders = $this->categoryService->makeCategoryTree();
        $products = $this->productRepository->getAll([], 6);

        return $this->returnResponseSuccess(
            new HomePageItem(
                new HomePageObject($genders, $products)
            ),
            'List of homepage objects'
        );
    }
}

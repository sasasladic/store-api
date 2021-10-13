<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Category\CategoryResource;
use App\Repositories\CategoryRepositoryInterface;

class CategoryController extends BaseController
{
    private CategoryRepositoryInterface $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $allCategories = $this->categoryRepository->getAll(false);
        if ($allCategories) {
            return $this->returnResponseSuccessWithPagination(
                CategoryResource::collection($allCategories),
                __('cruds.success.list', ['data' => 'categories'])
            );
        }
        return $this->returnResponseError([], 'No categories found');

    }

    public function tree()
    {
        $allCategories = $this->categoryRepository->getTree();
        if ($allCategories) {
            return $this->returnResponseSuccessWithPagination(
                CategoryResource::collection($allCategories),
                __('cruds.success.list', ['data' => 'categories'])
            );
        }
        return $this->returnResponseError([], 'No categories found');
    }
}

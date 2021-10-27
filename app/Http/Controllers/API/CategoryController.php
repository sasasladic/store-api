<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Category\CategoryResource;
use App\Http\Resources\API\Gender\GenderResource;
use App\Repositories\CategoryRepositoryInterface;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    private CategoryRepositoryInterface $categoryRepository;

    private CategoryService $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     * @param CategoryService $categoryService
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryService $categoryService
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
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
        $genders = $this->categoryService->makeCategoryTree();

        if ($genders) {
            return $this->returnResponseSuccessWithPagination(
                GenderResource::collection($genders),
                __('cruds.success.list', ['data' => 'categories'])
            );
        }
        return $this->returnResponseError([], 'No categories found');
    }
}

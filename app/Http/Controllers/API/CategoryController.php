<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Category\CategoryGenderResource;
use App\Http\Resources\API\Category\CategoryResource;
use App\Models\CategoryGender;
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
    public function children($children, $gender, $final_category_ids)
    {
        foreach ($children as $child) {
            $exist = CategoryGender::where('category_id', $child->id)->where('gender_id', $gender)->first();
            if (!$exist) {
                continue;
            }
            else {
                array_push($final_category_ids, $child);
                if (!empty($child->children)) {
                    $final_category_ids = $this->children($child->children, $gender, $final_category_ids);
                }
            }
        }

        return $final_category_ids;
    }

    public function tree()
    {
//        $category = Category::find(1);
//
//        $final_return_array =
//        dd($final_return_array);
//        $category->children = $this->children($category->children, 1);
//
//        dd($category->children);


        $genders = $this->categoryRepository->getTree();
        foreach ($genders as $gender) {
            foreach ($gender->categories as $category) {
                $final_category_ids = [];
                $category->childrensa = $this->children($category->children, $gender->id, $final_category_ids);
            }
        }

        if ($genders) {
            return $this->returnResponseSuccessWithPagination(
                CategoryGenderResource::collection($genders),
                __('cruds.success.list', ['data' => 'categories'])
            );
        }
        return $this->returnResponseError([], 'No categories found');
    }
}

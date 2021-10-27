<?php

namespace App\Services;

use App\Models\CategoryGender;
use App\Repositories\CategoryRepositoryInterface;

class CategoryService
{

    private CategoryRepositoryInterface $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
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

    public function makeCategoryTree()
    {
        $genders = $this->categoryRepository->getTree();

        foreach ($genders as $gender) {
            foreach ($gender->categories as $category) {
                $final_category_ids = [];
                $category->children = $this->children($category->children, $gender->id, $final_category_ids);
            }
        }

        return $genders;
    }
}

<?php

namespace App\Http\Resources\Admin\Category\Item;

use App\Http\Resources\Admin\Category\Model\CategoryCreate;
use App\Http\Resources\Admin\Category\Model\CategoryEdit;
use App\Http\Resources\Admin\Category\Resources\CategoryResource;
use App\Http\Resources\Admin\Category\Resources\CategorySearchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 */
class EditCategoryItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CategoryEdit $this */
        $category = $this->getCurrentCategory();
        if (count($category->genders) == 1) {
            $gender = $category->genders[0]->id;
        }elseif (count($category->genders) > 1) {
            $gender = 3;
        }

        return [
            'id' => $category->id,
            'name' => $category->getTranslations('name'),
            'description' => $category->getTranslations('description'),
            'parent' => new CategorySearchResource($category->parent),
            'active' => $category->active,
            'gender' => $gender,
            'children' => CategorySearchResource::collection($category->children),
            'categories' => CategoryResource::collection($this->getCategories()),
            'translation_languages' => $this->getLanguages(),
        ];
    }
}

<?php

namespace App\Http\Resources\Admin\Category\Item;

use App\Http\Resources\Admin\Category\Model\CategoryCreate;
use App\Http\Resources\Admin\Category\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 */
class CreateCategoryItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CategoryCreate $this */
        return [
            'categories' => CategoryResource::collection($this->getCategories()),
            'translation_languages' => $this->getLanguages()
        ];
    }
}

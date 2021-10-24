<?php

namespace App\Http\Resources\API\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        if ($this->name == 'Clothes') {
//            dd($this->childrensa);
//        }
        $children = collect($this->childrensa);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description, //$this->getTranslations('description'),
            'children' => count($children) ? self::collection(collect($children)) : null,
        ];
    }
}

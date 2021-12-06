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
        $children = collect($this->children);
        $categoryGenderId = null;
        if ($this->pivot && $this->pivot->id) {
            $categoryGenderId = $this->pivot->id;
        }
        if (!$categoryGenderId) {
            foreach ($this->genders as $gender) {
                if ($gender->id == $this->gender_id) {
                    $categoryGenderId = $gender->pivot->id;
                }
            }
        }

        return [
            'id' => $this->id,
            'category_gender_id' => $categoryGenderId ?? $this->genders[0]->pivot->id,
            'name' => $this->name,
            'description' => $this->description, //$this->getTranslations('description'),
            'children' => count($children) ? self::collection(collect($children)) : null,
        ];
    }
}

<?php

namespace App\Http\Resources\API\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryGenderResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->gender,
            'category' => CategoryResource::collection($this->categories)
        ];
    }
}

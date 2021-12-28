<?php

namespace App\Http\Resources\API\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class SelectCategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (count($this->genders) == 1) {
            $gender = $this->genders[0]->id;
        }elseif (count($this->genders) > 1) {
            $gender = 3;
        }

        return [
            'name' => $this->name,
            'gender' => $gender
        ];
    }
}

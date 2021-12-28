<?php

namespace App\Http\Resources\API\Gender;

use App\Helper\ImageHelper;
use App\Http\Resources\API\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GenderItem extends JsonResource
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
            'name' => $this->gender
        ];
    }
}

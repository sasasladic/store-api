<?php

namespace App\Http\Resources\Admin\Category\Resources;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description, //$this->getTranslations('description'),
            'children' => count($this->children) ? self::collection($this->children) : null
        ];
    }
}

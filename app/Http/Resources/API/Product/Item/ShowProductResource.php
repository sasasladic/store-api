<?php

namespace App\Http\Resources\API\Product\Item;

use App\Http\Resources\Admin\Category\Resources\CategorySearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductResource extends JsonResource
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
            'description' => $this->description,
            'category' => new CategorySearchResource($this->category),
            'images' => $this->images ? ProductImagesResource::collection($this->images) : null
        ];
    }
}

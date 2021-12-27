<?php

namespace App\Http\Resources\API\Product;

use App\Http\Resources\Admin\Category\Resources\CategorySearchResource;
use App\Http\Resources\Admin\Product\Resources\ProductImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->lowest)) {
            $price = $this->lowest;
        }else{
            if (count($this->activeVariants) > 0) {
                $price = $this->activeVariants[0]->price;
            }else{
                $price = 0;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => new CategorySearchResource($this->categoryGender->category),
            'image' => count($this->images) > 0 ? new ProductImagesResource($this->images[0]) : null,
            'price' => $price
        ];
    }
}

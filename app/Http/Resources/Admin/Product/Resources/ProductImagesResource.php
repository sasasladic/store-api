<?php

namespace App\Http\Resources\Admin\Product\Resources;

use App\Helper\ImageHelper;
use App\Http\Resources\Admin\Option\Resources\EditProductVariantOptionValuesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImagesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'src' => ImageHelper::getImageUrl($this->image_path)
        ];
    }
}

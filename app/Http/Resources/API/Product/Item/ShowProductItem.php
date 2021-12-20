<?php

namespace App\Http\Resources\API\Product\Item;

use App\Http\Resources\API\Product\Resources\ProductVariantsResource;
use App\Http\Resources\API\Product\Model\ShowProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductItem extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var $this ShowProduct */
        return [
            'product_data' => new ShowProductResource($this->getProduct()),
            'all_attributes' => $this->getAllOptions(),
            'all_variants' => ProductVariantsResource::collection($this->getVariants())
        ];
    }
}

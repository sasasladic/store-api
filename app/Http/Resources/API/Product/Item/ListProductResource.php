<?php

namespace App\Http\Resources\API\Product\Item;

use App\Http\Resources\API\Category\Item\ShowCategoryItem;
use App\Http\Resources\API\Product\Model\ListObject;
use App\Http\Resources\API\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ListProductResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var $this ListObject */
        return [
            'category' => new ShowCategoryItem($this->getCategory()),
            'products' => ProductResource::collection($this->getProducts()),
            'filters' => $this->getFilters()
        ];
    }
}

<?php

namespace App\Http\Resources\API\HomePage\Item;

use App\Http\Resources\API\Gender\GenderResource;
use App\Http\Resources\API\HomePage\Model\HomePageObject;
use App\Http\Resources\API\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 */
class HomePageItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var HomePageObject $this */
        return [
            'genders' => GenderResource::collection($this->getGeneders()),
            'products' => ProductResource::collection($this->getProducts()),
        ];
    }
}

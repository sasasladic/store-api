<?php

namespace App\Http\Resources\API\Order\Item;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductVariantItem extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $attributes = [];

        foreach ($this->optionValues as $optionValue) {
            $optionName = strtolower($optionValue->option->name);
            $attributes[$optionName] = $optionValue->value;
        }

        return array_merge(
            [
                'sku' => $this->sku,
                'price' => $this->price,
            ],
            $attributes
        );
    }
}

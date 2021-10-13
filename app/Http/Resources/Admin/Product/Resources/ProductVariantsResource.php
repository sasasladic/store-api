<?php

namespace App\Http\Resources\Admin\Product\Resources;

use App\Http\Resources\Admin\Option\Resources\EditProductVariantOptionValuesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantsResource extends JsonResource
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
//        foreach ($this->product->options as $option) {
//            $optionName = strtolower($option->name);
//            $merge[$optionName] = null;
//        }

        foreach ($this->optionValues as $optionValue) {
            $optionName = strtolower($optionValue->option->name);
            $attributes[$optionName] = $optionValue->value;
        }

        return array_merge(
            [
                'id' => $this->id,
                'sku' => $this->sku,
                'price' => $this->price,
                'in_stock' => $this->in_stock,
                'option_values' => EditProductVariantOptionValuesResource::collection($this->optionValues)
            ],
            $attributes
        );
    }
}

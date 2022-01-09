<?php

namespace App\Http\Resources\API\Order\Resources;

use App\Http\Resources\API\Order\Item\OrderProductVariantItem;
use App\Http\Resources\API\Product\Resources\ProductVariantsResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'quantity' => $this->quantity,
            'status' => array_search ($this->status, Order::STATUS),
            'total_sum' => $this->sum,
            'address' => $this->address,
            'ordered_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
            'variant' => new OrderProductVariantItem($this->productVariant)
        ];
    }
}

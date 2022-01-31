<?php

namespace App\Http\Resources\Admin\UserOrder\Resources;

use App\Http\Resources\Admin\Product\Resources\ProductVariantsResource;
use App\Http\Resources\Admin\User\Resources\UserSearchResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderResource extends JsonResource
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
            'user' => new UserSearchResource($this->user),
            'product_variant' => new ProductVariantsResource($this->productVariant),
            'status' => array_search ($this->status, Order::STATUS),
            'quantity' => $this->quantity,
            'sum' => $this->sum,
            'delivered' => $this->items_sent,
            'created_at' => $this->created_at->format('Y-m-d H:i:S'),
            'created_by' => $this->creator->name,
            'updated_at' => $this->created_at->format('Y-m-d H:i:S'),
            'updated_by' => new UserSearchResource($this->editor),
        ];
    }
}

<?php

namespace App\Http\Resources\Admin\Product\Resources;

use App\Http\Resources\Admin\Category\Resources\CategorySearchResource;
use App\Http\Resources\Admin\User\Resources\UserSearchResource;
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => new CategorySearchResource($this->category),
            'active' => $this->active,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_by' => new UserSearchResource($this->creator),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'updated_by' => new UserSearchResource($this->editor),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'deleted_by' => $this->destroyer ? new UserSearchResource($this->destroyer) : null
        ];
    }
}

<?php

namespace App\Http\Resources\Admin\User\Item;

use App\Http\Resources\Admin\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditItem extends JsonResource
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
            'email' => $this->email,
            'active' => $this->active,
            'role' => new RoleResource($this->role),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'created_by' => $this->creator ? $this->creator->name : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'updated_by' => $this->editor ? $this->editor->name : null,
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'deleted_by' => $this->destroyer ? $this->destroyer->name : null
        ];
    }
}

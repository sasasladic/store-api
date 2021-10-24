<?php

namespace App\Http\Resources\Admin\Category\Resources;

use App\Http\Resources\Admin\User\Resources\UserSearchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (count($this->genders) == 1) {
            $gender = $this->genders[0]->id;
        }elseif (count($this->genders) > 1) {
            $gender = 3;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description, //$this->getTranslations('description'),
            'children' => count($this->children) ? self::collection($this->children) : null,
            'parent' => $this->parent ? new CategorySearchResource($this->parent) : null,
            'gender' => $gender,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_by' => new UserSearchResource($this->creator),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'updated_by' => new UserSearchResource($this->editor),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'deleted_by' => $this->destroyer ? new UserSearchResource($this->destroyer) : null,
        ];
    }
}

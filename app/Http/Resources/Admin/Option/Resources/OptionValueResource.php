<?php

namespace App\Http\Resources\Admin\Option\Resources;

use App\Http\Resources\Admin\User\Resources\UserSearchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionValueResource extends JsonResource
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
            'value' => $this->value,
            'option_id' => $this->option->id
//            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
//            'created_by' => new UserSearchResource($this->creator),
//            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
//            'updated_by' => new UserSearchResource($this->editor),
        ];
    }
}

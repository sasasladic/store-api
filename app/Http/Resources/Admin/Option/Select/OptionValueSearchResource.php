<?php

namespace App\Http\Resources\Admin\Option\Select;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionValueSearchResource extends JsonResource
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
        ];
    }
}

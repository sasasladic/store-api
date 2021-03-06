<?php


namespace App\Http\Resources\Admin\Option\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OptionSearchResource extends JsonResource
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
            'name' => strtolower($this->name),
        ];
    }
}

<?php

namespace App\Http\Resources\SubResource;

use App\Http\Resources\Resource\ResourceMinResource;
use App\Http\Resources\Resource\ResourceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubResourceResourceMin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'examples' => $this->examples,
            'resource' => ResourceMinResource::make($this->my_resource)


        ];
    }
}

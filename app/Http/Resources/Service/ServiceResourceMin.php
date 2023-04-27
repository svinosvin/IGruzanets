<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Resource\ResourceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResourceMin extends JsonResource
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
            'resources' => ResourceTableResource::collection($this->my_resources),
            'img' => $this->imgUrl,
            'price_one_unit' => $this->price_one_unit

        ];
    }
}

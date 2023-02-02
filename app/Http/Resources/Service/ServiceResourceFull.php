<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Resource\ResourceMinResource;
use App\Http\Resources\Resource\ResourceResourceFull;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResourceFull extends JsonResource
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
            'resources' => ResourceMinResource::collection($this->my_resources),
        ];
    }
}

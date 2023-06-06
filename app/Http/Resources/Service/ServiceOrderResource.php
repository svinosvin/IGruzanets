<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Resource\ResourceTableResource;
use App\Http\Resources\Types\ServiceTypeResourceFull;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderResource extends JsonResource
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
            'resources' => ResourceTableResource::collection($this->my_resources),
            'price_one_unit' => $this->price_one_unit,
            'service_type' =>  ServiceTypeResourceFull::make($this->service_type),

        ];
    }
}

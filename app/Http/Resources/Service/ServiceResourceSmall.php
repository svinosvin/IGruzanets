<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Resource\ResourceTableResource;
use App\Http\Resources\Types\ServiceTypeResourceFull;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResourceSmall   extends JsonResource
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
        ];
    }
}

<?php

namespace App\Http\Resources\Resource;

use App\Http\Resources\Service\ServiceResourceMin;
use App\Http\Resources\SubResource\SubResourceResourceMin;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceResourceFull extends JsonResource
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
            'sub_resources' => SubResourceResourceMin::collection($this->sub_resources),
            'services' => ServiceResourceMin::collection($this->services),

        ];
    }
}

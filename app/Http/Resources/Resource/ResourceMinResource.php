<?php

namespace App\Http\Resources\Resource;

use App\Http\Resources\SubResource\SubResourceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceMinResource extends JsonResource
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
            'title'=> $this->title,
            'description' => $this->description,
            'examples' => $this->examples,
        ];
    }
}

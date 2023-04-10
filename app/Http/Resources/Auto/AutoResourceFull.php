<?php

namespace App\Http\Resources\Auto;

use App\Http\Resources\AutoCategory\AutoCategoryResourceMin;
use Illuminate\Http\Resources\Json\JsonResource;

class AutoResourceFull extends JsonResource
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
            'mark'=> $this->mark,
            'description' => $this->description,
            'img' => $this->imgUrl,
            'max_weight' => $this->max_weight,
            'auto_category' => new AutoCategoryResourceMin($this->auto_category)

        ];
    }
}

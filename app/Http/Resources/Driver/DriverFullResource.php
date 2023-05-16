<?php

namespace App\Http\Resources\Driver;

use App\Http\Resources\AutoCategory\AutoCategoryResourceMin;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverFullResource extends JsonResource
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
            'name' => $this->name,
            'img' => $this->imgUrl,
            'first_name' => $this->first_name,
            'patronymic' => $this->patronymic,
            'tel_number' => $this->tel_number,
            'categories' => AutoCategoryResourceMin::collection($this->auto_categories) ?? [],
            'is_active' => $this->is_active,
        ];
    }
}

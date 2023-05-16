<?php

namespace App\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverMinResource extends JsonResource
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
            'id' => $request->id,
            'name' => $request->name,
            'img' => $this->imgUrl,
            'first_name' => $request->first_name,
            'patronymic' => $request->patronymic,
            'tel_number' => $request->tel_number,
            'is_active' => $this->is_active,

        ];
    }
}

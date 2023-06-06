<?php

namespace App\Http\Resources\Auto;

use App\Http\Resources\AutoCategory\AutoCategoryResourceMin;
use App\Http\Resources\Service\ServiceResourceSmall;
use Illuminate\Http\Resources\Json\JsonResource;

class AutoOrderResource extends JsonResource
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
            'max_weight' => $this->max_weight,
            'car_numbers' => $this->car_numbers,
            'auto_category' => new AutoCategoryResourceMin($this->auto_category),
            'service' => ServiceResourceSmall::make($this->service),
            'mark' => $this->mark,
            'is_active' => $this->is_active,
        ];
    }
}

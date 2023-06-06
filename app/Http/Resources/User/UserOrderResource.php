<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Company\CompanyResourceMin;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderResource extends JsonResource
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
            'first_name' => $this->first_name,
            'patronymic' => $this->patronymic,

            'tel_number' => $this->tel_number,
            'email' => $this->email,
            'company' => CompanyResourceMin::make($this->company)

        ];
    }
}

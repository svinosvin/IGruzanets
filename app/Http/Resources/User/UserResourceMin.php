<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Company\CompanyResourceMin;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceMin extends JsonResource
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
            'email'=> $this->email,
            'name' => $this->name,
            'first_name'=> $this->first_name,
            'patronymic'=> $this->patronymic,
            'tel_number' => $this->tel_number,
            'company' => CompanyResourceMin::make($this->company)

        ];
    }
}

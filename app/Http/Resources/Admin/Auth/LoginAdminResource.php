<?php

namespace App\Http\Resources\Admin\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginAdminResource extends JsonResource
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
            'lastname'=> $this->lastname,
            'patronymic'=> $this->patronymic,
            'email_verified'=>$this->email_verified
        ];
    }
}

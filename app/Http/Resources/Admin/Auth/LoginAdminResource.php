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
            'id' => $request->id,
            'email'=> $request->email,
            'name' => $request->name,
            'lastname'=> $request->lastname,
            'patronymic'=> $request->patronymic,
            'email_verified'=>$request->email_verified
        ];
    }
}

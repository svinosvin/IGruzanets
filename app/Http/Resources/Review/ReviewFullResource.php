<?php

namespace App\Http\Resources\Review;

use App\Http\Resources\User\UserOrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewFullResource extends JsonResource
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
            'review' => $this->review,
            'is_active' => $this->is_active,
            'user' => UserOrderResource::make($this->user),

        ];
    }
}

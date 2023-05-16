<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Types\OrderTypeResourceFull;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSmallResource extends JsonResource
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
            'service_title'=> $this->service->title,
            'address' => $this->address,
            'weight' => $this->weight,
            'order_type' => OrderTypeResourceFull::make($this->order_type),
            'total_price'=> $this->total_price,
            'order_at' => $this->orderDate,
        ];
    }
}

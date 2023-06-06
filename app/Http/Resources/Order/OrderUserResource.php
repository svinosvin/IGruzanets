<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Auto\AutoOrderResource;
use App\Http\Resources\Driver\DriverOrderResource;
use App\Http\Resources\Resource\ResourceTableResource;
use App\Http\Resources\Service\ServiceOrderResource;
use App\Http\Resources\Types\OrderTypeResourceFull;
use App\Http\Resources\User\UserOrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUserResource extends JsonResource
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
            'service'=> ServiceOrderResource::make($this->service),
            'auto'=> AutoOrderResource::make($this->auto) ,
            'driver'=> DriverOrderResource::make($this->driver),
            'resource'=> ResourceTableResource::make($this->my_resource),
            'name' => $this->name,
            'tel_number' => $this->tel_number,
            'notice' => $this->notice,
            'address' => $this->address,
            'weight' => $this->weight,
            'order_type' => OrderTypeResourceFull::make($this->order_type),
            'total_price'=> $this->total_price ?? null,
            'order_at' => $this->orderDate,
        ];
    }
}

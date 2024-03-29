<?php

namespace App\Models;

use App\Helpers\OrderStatusConstant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table='orders';



    public $timestamps = false;

    public function scopeOrderAt(Builder $query, $date) : Builder
    {
        $dateString = preg_replace('/\(.*$/', '', $date);
        $date = \Carbon\Carbon::parse($dateString)->format('Y-m-d H:i:s');
        $dateMin = \Carbon\Carbon::make($date)->subDay();
        $dateMax = \Carbon\Carbon::make($date)->addDay();

        return $query
            ->whereDate('order_at', '>', $dateMin )
            ->whereDate('order_at', '<', $dateMax );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function driver(){
        return $this->belongsTo(Driver::class);
    }
    public function auto(){
        return $this->belongsTo(Auto::class);
    }
    public function my_resource(){
        return $this->belongsTo(Resource::class, 'resource_id', 'id');
    }

    public function order_type(){
        return $this->belongsTo(OrderType::class, 'order_types_id', 'id');
    }

    public function getOrderDateAttribute(){

        return \Carbon\Carbon::parse($this->order_at)->format('d-m-Y H:i:s');
    }

}

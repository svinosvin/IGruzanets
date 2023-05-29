<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderMakeOrderRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\Order\OrderFullResource;
use App\Models\Auto;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderType;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    public function getAll()
    {
        $orders = QueryBuilder::for(Order::class)
            ->with(['service', 'user', 'driver', 'order_type'])
            ->allowedFilters([
                AllowedFilter::exact('order_type', 'order_types_id'),
                AllowedFilter::exact('service', 'service_id'),
                AllowedFilter::exact('user', 'user_id'),
                AllowedFilter::scope('order_at'),
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        return OrderFullResource::collection( $orders);
    }


    public function findCarForOrder(int $order){
        $order = Order::findOrFail($order);
        $date_start = \Carbon\Carbon::make($order->order_at)->subHour();
        $date_finish = \Carbon\Carbon::make($order->order_at)->addHours(2);

        $reserved_autos_id = Order::
         whereBetween('order_at', [$date_start, $date_finish])
            ->where('order_types_id', '!=', 3)
            ->whereNotNull('auto_id')
            ->where('id','!=', $order->id)
            ->get()
            ->pluck('auto_id');


        $autos = Auto::
            whereNotIn('id', $reserved_autos_id)
            ->where('max_weight' ,'>=', ($order->weight/1000))
            ->where('is_active','=', true)
            ->where('service_id','=', $order->service->id)
            ->get();

        if(count($autos)===0)
            return response()->json('Все машины забронированы на это время', 206);

        $auto = $autos->random();
        $order->auto()->disassociate();
        $order->auto()->associate($auto);
        $order->save();
        return response()->json('success', 206);


    }

    public function findDriverForOrder(int $order){
        $order = Order::findOrFail($order);
        $date_start = \Carbon\Carbon::make($order->order_at)->subHour();
        $date_finish = \Carbon\Carbon::make($order->order_at)->addHours(2);

        $reserved_driver_id = Order::with('driver'
        )->whereBetween('order_at', [$date_start, $date_finish])
            ->where('order_types_id', '!=', 3)
            ->whereNotNull('driver_id')
            ->where('id','!=', $order->id)
            ->get()
            ->pluck('driver_id');

        $auto = array($order->auto->auto_category->id);

        $drivers = Driver::with('auto_categories')
            ->
             select('drivers.*'
            )
            ->whereNotIn('drivers.id', $reserved_driver_id)
            ->join('driver_auto_categories as categories', 'categories.driver_id', '=','drivers.id')
            ->whereIn('category_id', $auto)
            ->where('is_active','=', true)
            ->get();

        if(count($drivers)===0)

            return response()->json('Все машины забронированы на это время', 406);

            $driver = $drivers->random();
            $order->driver()->disassociate();
            $order->driver()->associate($driver);
            $order->save();
            return response()->json('success', 206);

    }

    public function getByUser(int $userID)
    {
        $user = Auth::user();
        $orders = QueryBuilder::for(Order::class)
            ->with(['service', 'user', 'driver', 'order_type'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return OrderFullResource::collection($orders);
    }


    public function store(OrderMakeOrderRequest $request)
    {

        $data = $request->validated();
        $date = $data['order_at'];
        unset($data['order_at']);
        $data['order_at'] = \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
//23.05.2023 17:45:46
        $order = Order::create($data);
        $order->save();

        return OrderFullResource::make($order);

    }

    public function getById( int $id)
    {
      $order = Order::findOrFail($id);
      return OrderFullResource::make($order);

    }

    public function update(OrderUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $date = $data['order_at'];
        unset($data['order_at']);
        $data['order_at'] = \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
//23.05.2023 17:45:46

        $order = Order::findOrFail($id);
        $order->update($data);
        return OrderFullResource::make($order);
    }

    public function acceptOrder(int $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'order_types_id' => 2
        ]);
        return OrderFullResource::make($order);
    }
    public function finishOrder(int $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'order_types_id' => 3
        ]);
        return OrderFullResource::make($order);
    }
    public function declineOrder(int $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 206);
    }


    public function destroy(int $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 206);
    }
}

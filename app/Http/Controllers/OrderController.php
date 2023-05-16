<?php

namespace App\Http\Controllers;

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

class OrderController extends Controller
{
    public function getAll()
    {
        return OrderFullResource::collection(Order::all());
    }
    public function getLatest()
    {
        return OrderFullResource::collection(Order::all());
    }
    public function getByType(int $orderTypeId)
    {
        $type = OrderType::findOrFail($orderTypeId);
        $orders = Order::
        with('user','service.resources', 'service.service_type','driver', 'auto')
            ->where('order_types_id', $type->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return OrderFullResource::collection($orders);
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
        $user = User::findOrFail($userID);
        $orders = Order::
        with('service.resources', 'service.service_type','driver', 'auto')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return OrderFullResource::collection($orders);
    }



    public function newOrder(Request $request){

        $data = $request->validated();
        $user_id = $data['user'] ?? null;
        $service = Service::findOrFail($data['service']);
        $price = $service->price_one_unit;
        unset($data['service']);
        $order = Order::create([
            'service_id' => $data['service'],
            'tel_number' => $data['tel_number'],
            'name' => $data['name'],
            'address' => $data['address'],
            'weight' => $data['weight'],
            'total_price' => $price * $data['weight'],
            'order_at' => $data['order_at'],
            'notice' => $data['notice'],
            'status' => 1,
            'is_accepted' => 0,
        ]);
        $order->save();
        if($user_id){
            $user = User::findOrFail($user_id);
            $order->update([
                'user_id'=> $user->id,
                'tel_number' => $user->tel_number ,
                'name' => $user->name,
             ]);
        }

        return response()->json(null, 206);
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        $user_id = $data['user'] ?? null;
        $service = Service::findOrFail($data['service']);
        $price = $service->price_one_unit;
        unset($data['service']);
        $order = Order::create([
            'service_id' => $data['service'],
            'tel_number' => $data['tel_number'],
            'name' => $data['name'],
            'address' => $data['address'],
            'weight' => $data['weight'],
            'total_price' => $price * $data['weight'],
            'order_at' => $data['order_at'],
            'notice' => $data['notice'],
            'status' => 1,
            'is_accepted' => 0,
        ]);
        $order->save();
        if($user_id){
            $user = User::findOrFail($user_id);
            $order->update([
                'user_id'=> $user->id,
                'tel_number' => $user->tel_number ,
                'name' => $user->name,
            ]);
        }

        return response()->json(null, 206);
    }

    public function getById( int $id)
    {
      $order = Order::findOrFail($id);
      return OrderFullResource::make($order);

    }

    public function update( OrderUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $order = Order::findOrFail($id);
        $order = Order::update([
            $data
        ]);

        return OrderFullResource::make($order);
    }

    public function destroy(int $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 206);
    }
}

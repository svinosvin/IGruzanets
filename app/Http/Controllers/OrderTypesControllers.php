<?php

namespace App\Http\Controllers;

use App\Http\Resources\Order\OrderFullResource;
use App\Http\Resources\Types\OrderTypeResourceFull;
use App\Models\OrderType;
use Illuminate\Http\Request;

class OrderTypesControllers extends Controller
{
    public function getAll(){
        return OrderTypeResourceFull::collection(OrderType::all());
    }
}

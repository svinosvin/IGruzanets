<?php

namespace App\Http\Controllers;

use App\Http\Resources\Types\ServiceTypeResourceFull;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypesControllers extends Controller
{
    public function getAll(){
        return ServiceTypeResourceFull::collection(ServiceType::all());
    }
}

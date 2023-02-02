<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\Service\ServiceResourceFull;
use App\Http\Resources\Service\ServiceResourceMin;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function getAll()
    {
        return ServiceResourceMin::collection(Service::all());
    }


    public function store(ServiceStoreRequest $request)
    {
        $data = $request->validated();
        $resources = $data['resources'] ?? null;
        unset($data['resources']);
        $service = Service::create($data);
        if($resources){
            $service->attachUniqueResources($resources);
        }
        return ServiceResourceFull::make($service);
    }


    public function getById(int $id)
    {
        $service = Service::findOrFail($id);

        if(!$service){
            return JsonExceptionResponse::error("Service doesn't exist");
        }

        return  ServiceResourceFull::make($service);

    }

    public function update(ServiceUpdateRequest $request, int $id)
    {
        $service = Service::findOrFail($id);
        if(!$service){
            return JsonExceptionResponse::error("Service doesn't exist");
        }
        $data = $request->validated();
        $resources = $data['resources'] ?? null;
        unset($data['resources']);
        $service->update($data);
        if($resources){
            $service->attachUniqueResources($resources);
        }
        return ServiceResourceFull::make($service);

    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if(!$service){
            return JsonExceptionResponse::error("Service doesn't exist");
        }
        $service->my_resources()->detach();
        $service->delete();
        return response()->json(null, 206);
    }
}

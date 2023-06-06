<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Http\CommandBus\Commands\Image\ImageRemoveCommand;
use App\Http\CommandBus\Handlers\Image\ImageAddHandler;
use App\Http\CommandBus\Handlers\Image\ImageRemoveHandler;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Requests\ServiceImageAddRequest;
use App\Http\Resources\Service\ServiceResourceFull;
use App\Http\Resources\Service\ServiceResourceMin;
use App\Models\Image;
use App\Models\Resource;
use App\Models\Service;
use App\Models\ServiceImages;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function getAll()
    {
        return ServiceResourceMin::collection(Service::orderBy('service_types_id', 'asc')->get());
    }


    public function store(ServiceStoreRequest $request, ImageAddHandler $handler)
    {
        $data = $request->validated();
        $image = $request->file('img');
        $resources = json_decode($data['resources']) ?? null;
        $data['service_types_id'] = $data['service_type'] ?? null;
        unset($data['service_type']);
        unset($data['resources']);
        unset($data['img']);

        $path = null;
        if($image){
            $command = new ImageAddCommand($image, Image::FOLDER_SERVICE);
            $path = $handler->handle($command);
        }
        $data['img'] = $path;
        $service = Service::create($data);
        $service->save();

        if($resources)
        {
            foreach ($resources as $resource_id) {
                if(Resource::find($resource_id)===null){
                    return JsonExceptionResponse::error("Resource № {$resource_id} does not exist!", 406);
                }
            }
        }
        $service->my_resources()->sync($resources);

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

    public function update(ServiceUpdateRequest $request, int $id, ImageAddHandler $handler, ImageRemoveHandler $removeHandler)
    {

        $service = Service::findOrFail($id);
        if(!$service){
            return JsonExceptionResponse::error("Service doesn't exist");
        }

        $data = $request->validated();
        $image = $request->file('img');

        $path = null;
        if($image){
            $command = new ImageAddCommand($image, Image::FOLDER_SERVICE);
            $path = $handler->handle($command);
        }
        if($path!=null && $service->img){
            $command = new ImageRemoveCommand($service->img);
            $removeHandler->handle($command);
        }
        $data['service_types_id'] = $data['service_type'] ?? null;
        $resources = json_decode($data['resources']) ?? null;
        unset($data['resources']);
        unset($data['service_type']);
        unset($data['img']);

        $data['img'] = $path ?? $service->img;
        $service->update($data);

        if($resources)
        {
            foreach ($resources as $resource_id) {
                if(Resource::find($resource_id)===null){
                    return JsonExceptionResponse::error("Resource № {$resource_id} does not exist!", 406);
                }
            }

        }

        $service->my_resources()->sync($resources);
        return ServiceResourceFull::make($service);

    }


    public function destroy($id, ImageRemoveHandler $handler)
    {
        $service = Service::findOrFail($id);
        if(!$service){
            return JsonExceptionResponse::error("Service doesn't exist");
        }
        if($service->img){
            $command = new ImageRemoveCommand($service->img, Image::FOLDER_SERVICE);
            $handler->handle($command);
        }
        $service->my_resources()->detach();
        $service->delete();
        return response()->json(null, 206);
    }


}

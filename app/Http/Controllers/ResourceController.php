<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\Resource\ResourceStoreRequest;
use App\Http\Requests\Resource\ResourceUpdateRequest;
use App\Http\Resources\Resource\ResourceMinResource;
use App\Http\Resources\Resource\ResourceResourceFull;
use App\Models\Resource;
use App\Models\SubResource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    public function getAll()
    {
        return ResourceMinResource::collection(Resource::all());
    }


    public function store(ResourceStoreRequest $request)
    {
        $data = $request->validated();
        $subresources = $data['sub_resources'] ?? null;
        $services = $data['services'] ?? null;
        unset($data['sub_resources']);
        unset($data['services']);

        $resource = Resource::create($data);
        $resource->save();
        if($subresources)
        {
            $resource->attachUniqueSubResource($subresources);
        }
        if($services){
            $resource->attachUniqueService($services);
        }

        return ResourceResourceFull::make($resource);

    }

    public function getById(int $id)
    {
        if($resource = Resource::findOrFail($id)){
            return ResourceResourceFull::make($resource);
        }
        return JsonExceptionResponse::error("Resource doesn't exist");
    }

    public function update(ResourceUpdateRequest $request, $id)
    {
        $resource = Resource::findOrFail($id);
        if(!$resource){
            return JsonExceptionResponse::error("Resource doesn't exist");
        }

        $data = $request->validated();
        $subresources = $data['sub_resources'] ?? null;
        $services = $data['services'] ?? null;
        unset($data['sub_resources']);
        unset($data['services']);

        $resource->update($data);
        if($subresources)
        {
            $resource->attachUniqueSubResource($subresources);
        }
        if($services){
            $resource->attachUniqueService($services);
        }
        return ResourceResourceFull::make($resource);


    }

    public function destroy(int $id)
    {
        $resource = Resource::findOrFail($id);
        if(!$resource){
            return JsonExceptionResponse::error("Resource doesn't exist");
        }
        $resource->delete();
        return response()->json(null, 206);
    }
}

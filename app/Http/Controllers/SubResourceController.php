<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\SubResource\SubResourceStoreRequest;
use App\Http\Requests\SubResource\SubResourceUpdateRequest;
use App\Http\Resources\SubResource\SubResourceResourceFull;
use App\Http\Resources\SubResource\SubResourceResourceMin;
use App\Models\SubResource;
use Illuminate\Http\Request;

class SubResourceController extends Controller
{

    public function getAll()
    {
        return SubResourceResourceMin::collection(SubResource::all());
    }

    public function store(SubResourceStoreRequest $request)
    {
        $subresource = SubResource::create([
            'title'=> $request->title,
            'description' => $request->description,
            'examples' => $request->examples,
        ]);
        if($resource = $request->resources)
        {
            $subresource->attachUniqueResources($resource);
        }
        return SubResourceResourceFull::make($subresource);
    }

    public function getById(int $id){

        $subresource = SubResource::findOrFail($id) ?? null;
        if(!$subresource)
            return JsonExceptionResponse::error("Subresource doesn't exist", 406);

        return SubResourceResourceFull::make($subresource);
    }


    public function update(SubResourceUpdateRequest $request, $id)
    {
        $subresource = SubResource::findOrFail($id) ?? null;
        if(!$subresource)
            return JsonExceptionResponse::error("Subresource doesn't exist", 406);

        $data = $request->validated();
        $resources = $data['resources'] ?? null;
        unset($data['resources']);

        $subresource->update($data);
        if($resources)
        {
                $subresource->attachUniqueResources($resources);
        }
        return SubResourceResourceFull::make($subresource);
    }


    public function destroy(int $id)
    {
        $subresource = SubResource::findOrFail($id);
        $subresource->my_resources()->detach();
        $subresource->delete();
        return response()->json(null, 204);
    }
}

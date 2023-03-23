<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\SubResource\SubResourceStoreRequest;
use App\Http\Requests\SubResource\SubResourceUpdateRequest;
use App\Http\Resources\SubResource\SubResourceResourceFull;
use App\Http\Resources\SubResource\SubResourceResourceMin;
use App\Models\Resource;
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
        $data = $request->validated();
        $subresource = SubResource::create([
            'title'=> $data['title'],
            'description' => $data['description'],
            'examples' => $data['examples'],
        ]);

        $resource_id = $data['resource'] ?? null;
        if($resource_id !== null ){
            if(Resource::find($resource_id) === null){
                return JsonExceptionResponse::error("Resource with id={$resource_id} doesn't exist", 406);
            }
            $subresource->my_resource()->associate($resource_id);
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
        var_dump($data['resource'] ?? 'dasdasdas');

        $resource_id = $data['resource'] ?? null;
        unset($data['resource']);
        $subresource->update($data);

        if($resource_id !== null ){
            if(Resource::find($resource_id) === null){
                return JsonExceptionResponse::error("Resource with id={$resource_id} doesn't exist", 406);
            }
            $subresource->my_resource()->associate($resource_id);
        }
        else{
            $subresource->my_resource()->disassociate();
        }

        $subresource->save();
        return SubResourceResourceFull::make($subresource);
    }


    public function destroy(int $id)
    {
        $subresource = SubResource::findOrFail($id);
        $subresource->my_resource()->disassociate();
        $subresource->delete();
        return response()->json(null, 204);
    }
}

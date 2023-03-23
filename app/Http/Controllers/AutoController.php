<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Http\CommandBus\Handlers\Image\ImageAddHandler;
use App\Http\Requests\Auto\AutoStoreRequest;
use App\Http\Requests\Auto\AutoUpdateRequest;
use App\Http\Resources\Auto\AutoResourceFull;
use App\Models\Auto;
use App\Models\AutoCategory;
use App\Models\Image;
use Illuminate\Http\Request;

class AutoController extends Controller
{

    public function getAll()
    {
       return AutoResourceFull::collection(Auto::all());
    }

    public function getById(int $id){

        $auto = Auto::findOrFail($id) ?? null;
        if(!$auto){
            return JsonExceptionResponse::error("Autp doesn't exist");
        }
        return AutoResourceFull::make($auto);

    }


    public function store(AutoStoreRequest $request, ImageAddHandler $handler)
    {
        if(!AutoCategory::findOrFail($request->auto_category_id) && $request->auto_category_id){
            return JsonExceptionResponse::error("Auto Category doesn't exist");
        }
        $data = $request->validated();


        $image = $request->file('img');
        $path = null;
        if(!$image){
            $command = new ImageAddCommand($image->getClientOriginalName());
            $path = $handler->handle($command, Image::FOLDER_AUTO);
        }

        $auto = Auto::create([
            'mark' => $data['mark'] ?? null,
            'description' => $data['description'] ?? null,
            'img' => $path,
            'max_weight' => $data['max_weight'] ?? null,
            'auto_category_id' => $data['auto_category_id'] ?? null,
        ]);
        return AutoResourceFull::make($auto);
    }


    public function update(AutoUpdateRequest $request, int $id, ImageAddHandler $handler)
    {

        $auto = Auto::findOrFail($id);

        if(!AutoCategory::findOrFail($request->auto_category_id) && $request->auto_category_id){
            return JsonExceptionResponse::error("Auto Category doesn't exist");
        }
        $data = $request->validated();
        $image = $request->file('img');
        $path = null;
        if(!$image){
            $command = new ImageAddCommand($image->getClientOriginalName(), Image::FOLDER_AUTO);
            $path = $handler->handle($command,  Image::FOLDER_AUTO);
        }

        $auto->update([
            'mark' => $data['mark'] ,
            'description' => $data['description'],
            'img' => $path,
            'max_weight' => $data['max_weight'],
            'auto_category_id' => $data['auto_category_id'],
        ]);

        return AutoResourceFull::make($auto);
    }

    public function destroy(int $id)
    {
        $auto = Auto::findOrFail($id);
        $auto->delete();
        return response()->json(null, 204);
    }
}

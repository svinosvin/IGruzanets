<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Http\CommandBus\Commands\Image\ImageRemoveCommand;
use App\Http\CommandBus\Handlers\Image\ImageAddHandler;
use App\Http\CommandBus\Handlers\Image\ImageRemoveHandler;
use App\Http\Requests\Auto\AutoStoreRequest;
use App\Http\Requests\Auto\AutoUpdateRequest;
use App\Http\Resources\Auto\AutoResourceFull;
use App\Models\Auto;
use App\Models\AutoCategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Storage;

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

        $data = $request->validated();
        $image = $request->file('img');

        $path = null;
        if($image){
            $command = new ImageAddCommand($image, Image::FOLDER_AUTO);
            $path = $handler->handle($command);
        }


        $auto = Auto::create([
            'mark' => $data['mark'] ?? null,
            'description' => $data['description'] ?? null,
            'img' => $path,
            'max_weight' => $data['max_weight'] ?? null,
            'auto_category_id'=> $data['auto_category'] ?? null
        ]);


        return AutoResourceFull::make($auto);
    }


    public function update(AutoUpdateRequest $request, int $id, ImageAddHandler $handler, ImageRemoveHandler $removeHandler)
    {
        $auto = Auto::findOrFail($id);
        $data = $request->validated();

        if ($data['auto_category']!=null && AutoCategory::find($data['auto_category']) === null)
        {
            return JsonExceptionResponse::error('Водительская категория не найдена!');
        }

        $image = $request->file('img');
        $path = null;

        if($image){
            $command = new ImageAddCommand($image, Image::FOLDER_AUTO);
            $path = $handler->handle($command);
        }

        if($path!=null && $auto->img){
            $command = new ImageRemoveCommand($auto->img, Image::FOLDER_AUTO);
            $removeHandler->handle($command);
        }

        $auto->update([
            'mark' => $data['mark'] ,
            'description' => $data['description'],
            'img' => $path,
            'max_weight' => $data['max_weight'],
            'auto_category_id' => $data['auto_category'],
        ]);
        return AutoResourceFull::make($auto);
    }

    public function destroy(int $id, ImageRemoveHandler $handler)
    {
        $auto = Auto::findOrFail($id);
        if($auto->img){
            $command = new ImageRemoveCommand($auto->img, Image::FOLDER_AUTO);
            $handler->handle($command);
        }

        $auto->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Http\CommandBus\Commands\Image\ImageRemoveCommand;
use App\Http\CommandBus\Handlers\Image\ImageAddHandler;
use App\Http\CommandBus\Handlers\Image\ImageRemoveHandler;
use App\Http\Requests\Driver\DriverStoreRequest;
use App\Http\Requests\Driver\DriverUpdateRequest;
use App\Http\Resources\Driver\DriverFullResource;
use App\Models\AutoCategory;
use App\Models\Driver;
use App\Models\Image;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    public function getAll()
    {
        return DriverFullResource::collection(Driver::all());
    }



    public function store(DriverStoreRequest $request, ImageAddHandler $handler)
    {
        $data = $request->validated();
        $image = $request->file('img');

        $categoriesID = json_decode($data['categories']) ?? null;

        unset($data['categories']);

        $path = null;
        if($image){
            $command = new ImageAddCommand($image, Image::FOLDER_DRIVER);
            $path = $handler->handle($command);
        }
        $driver = Driver::create([
            'name' => $data['name'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'patronymic' => $data['patronymic'] ?? null,
            'tel_number' => $data['tel_number'] ?? null,
            'img' => $path ?? null,
        ]);
        $driver->save();

        if($categoriesID){
            foreach ($categoriesID as $category){
                $driver->auto_categories()->attach($category);
            }
        }
        return DriverFullResource::make($driver);
    }

    public function getById(int $id){

        $driver = Driver::findOrFail($id);
        if(!$driver)
            return JsonExceptionResponse::error("Driver doesn't exist", 406);
        return DriverFullResource::make($driver);
    }



    public function update(DriverUpdateRequest $request, int $id,  ImageAddHandler $handler, ImageRemoveHandler $removeHandler)
    {
        $driver = Driver::findOrFail($id);
        $data = $request->validated();

        $image = $request->file('img');
        $path = null;

        if($image){
            $command = new ImageAddCommand($image, Image::FOLDER_DRIVER);
            $path = $handler->handle($command);
        }

        if($path!=null && $driver->img){
            $command = new ImageRemoveCommand($driver->img);
            $removeHandler->handle($command);
        }

        $categories = json_decode($data['categories']) ?? null;
        unset($data['categories']);
        $driver->update([
            'name' => $data['name'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'patronymic' => $data['patronymic'] ?? null,
            'tel_number' => $data['tel_number'] ?? null,
            'img' => $path ?? $driver->img,
        ]);

        foreach ($categories as $category_id){
            if(AutoCategory::find($category_id) === null){
                return JsonExceptionResponse::error("Категория №${category_id} не найдена", 451);
            }
        }
        $driver->auto_categories()->sync($categories);
        $driver->save();
        return DriverFullResource::make($driver);
    }


    public function destroy(int $id, ImageRemoveHandler $handler)
    {
        $driver = Driver::findOrFail($id);
        $driver->auto_categories()->detach();

        if($driver->img){
            $command = new ImageRemoveCommand($driver->img, Image::FOLDER_DRIVER);
            $handler->handle($command);
        }
        $driver->delete();
        return response()->json(null, 204);
    }
}

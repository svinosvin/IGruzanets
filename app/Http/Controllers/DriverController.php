<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\Driver\DriverStoreRequest;
use App\Http\Requests\Driver\DriverUpdateRequest;
use App\Http\Resources\Driver\DriverFullResource;
use App\Models\AutoCategory;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    public function getAll()
    {
        return DriverFullResource::collection(Driver::all());
    }



    public function store(DriverStoreRequest $request)
    {
        $data = $request->validated();
        $categoriesID = $data['categories'] ?? null;
        unset($data['categories']);
        $driver =  Driver::create($data);
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



    public function update(DriverUpdateRequest $request, int $id)
    {
        $driver = Driver::findOrFail($id);
        $data = $request->validated();

        $categories = $data['categories'] ?? null;
        unset($data['categories']);
        $driver->updateOrFail($data);

        foreach ($categories as $category_id){
            if(AutoCategory::find($category_id) === null){
                return JsonExceptionResponse::error("Категория №${category_id} не найдена", 451);
            }
        }
        $driver->auto_categories()->sync($categories);
        $driver->save();
        return DriverFullResource::make($driver);
    }


    public function destroy(int $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->auto_categories()->detach();
        $driver->delete();
        return response()->json(null, 204);
    }
}

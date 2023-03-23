<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Resources\AutoCategory\AutoCategoryResourceFull;
use App\Models\AutoCategory;
use Illuminate\Http\Request;
use App\Http\Requests\AutoCategory\AutoCategoryStoreRequest;
use App\Http\Requests\AutoCategory\AutoCategoryUpdateRequest;
use Illuminate\Http\Response;

class AutoCategoryController extends Controller
{
    public function getAll()
    {
        return AutoCategoryResourceFull::collection(AutoCategory::all());
    }
    public function getById(int $id){

        $category = AutoCategory::findOrFail($id) ?? null;
        if(!$category){
            return JsonExceptionResponse::error("Category doesn't exist", Response::HTTP_BAD_REQUEST);
        }
        return AutoCategoryResourceFull::make($category);

    }

    public function store(AutoCategoryStoreRequest $request)
    {

        $category = AutoCategory::create($request->all());
        return AutoCategoryResourceFull::make($category);
    }


    public function update(AutoCategoryUpdateRequest $request, int $id)
    {
        $category = AutoCategory::findOrFail($id);
        if(!$category){
            return JsonExceptionResponse::error("Category doesn't exist", Response::HTTP_BAD_REQUEST);
        }
        $category->update($request->all());
        return AutoCategoryResourceFull::make($category);
    }

    public function destroy(int $id)
    {
        $category = AutoCategory::findOrFail($id);
        if(!$category){
            return JsonExceptionResponse::error("Category doesn't exist", Response::HTTP_BAD_REQUEST);
        }
        $category->delete();
        return response()->json(null, 204);
    }
}

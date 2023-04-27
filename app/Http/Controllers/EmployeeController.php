<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\CommandBus\Commands\Admin\AdminCreateCommand;
use App\Http\CommandBus\Handlers\Admin\AdminCreateHandler;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Http\Requests\Main\UserStoreRequest;
use App\Http\Requests\Main\UserUpdateRequest;
use App\Http\Resources\Admin\AdminFullResource;
use App\Http\Resources\User\UserResourceMin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
class EmployeeController extends Controller
{
    public function getAll()
    {
        return AdminFullResource::collection(Admin::all());
    }

    public function store(AdminCreateRequest $request, AdminCreateHandler $handler)
    {
        $data = $request->validated();
        $command = new AdminCreateCommand($data);

        return $handler->handle($command);
    }


    public function update(AdminUpdateRequest $request, int $id){

        $admin = Admin::findOrFail($id);
        if(!$admin)
            return JsonExceptionResponse::error('Not Authorized!', 406);

        $admin->update($request->validated());
        return AdminFullResource::make($admin);
    }


    public function getById(int $id){
        $admin = Admin::findOrFail($id) ?? null;
        if(!$admin){
            return JsonExceptionResponse::error("Admin doesn't exist", 406);
        }
        return AdminFullResource::make($admin);
    }

    public function destroy(int $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return response()->json(null, 204);

    }


}

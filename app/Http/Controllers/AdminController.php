<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Http\Resources\Admin\AdminFullResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{



    public function profile(){
        $admin = Auth::user();
        return AdminFullResource::make($admin);
    }

    public function changeAdminData(AdminUpdateRequest $request){
        $admin = Auth::user();
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

}

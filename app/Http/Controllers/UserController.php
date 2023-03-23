<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\Main\UserUpdateRequest;
use App\Http\Resources\User\UserResourceMin;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getAll()
    {
        return UserResourceMin::collection(User::all());
    }


    public function changeUserData(UserUpdateRequest $request){
        $user = Auth::user();
        if(!$user)
            return JsonExceptionResponse::error('Not Authorized!', 406);
        $user->update($request->validated());
        return UserResourceMin::make($user);
    }

    public function profile(){
        $user = Auth::user();
        if(!$user)
            return JsonExceptionResponse::error('Not Authorized!', 406);

        return response()->json([
            'user'=> UserResourceMin::make($user)
        ], 201);
    }





}

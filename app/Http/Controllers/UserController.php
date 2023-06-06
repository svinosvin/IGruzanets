<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonExceptionResponse;
use App\Http\Requests\Main\UserStoreRequest;
use App\Http\Requests\Main\UserUpdateRequest;
use App\Http\Resources\User\UserResourceMin;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getAll()
    {
        return UserResourceMin::collection(User::all());
    }

    public function getById(int $id){

        $user = User::findOrFail($id);
        return UserResourceMin::collection($user);
    }

    public function store(UserStoreRequest $request){

        $data = $request->validated();
        if($data['company']!==null &&!Company::find($data['company'])){
            return JsonExceptionResponse::error('Такой компании не существует');
        }

        $user = User::create([
            'name' => $data['name'] ?? null,
            'surname' => $data['surname'] ?? null,
            'patronymic' => $data['patronymic'] ?? null,
            'tel_number' => $data['tel_number'] ?? null,
            'password' => $data['password'] ?? null,
            'company_id' => $data['company'] ?? null
        ]);
        return UserResourceMin::make($user);
    }
    public function update(UserUpdateRequest $request, int $id){


        $data = $request->validated();
        if($data['company']!==null &&!Company::find($data['company'])){
            return JsonExceptionResponse::error('Такой компании не существует');
        }

        $company = $data['company'] ?? null;
        unset($data['company']);
        $user = User::findOrFail($id);
        $user->update($data);

        if($company!=null){
            $user->company()->associate($company);
        }
        $user->save();
        return UserResourceMin::make($user);
    }

    public function destroy(int $id){
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);

    }



}

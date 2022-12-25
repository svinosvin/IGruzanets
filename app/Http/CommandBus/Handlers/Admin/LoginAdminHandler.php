<?php

namespace App\Http\CommandBus\Handlers\Admin;


use App\Http\CommandBus\Commands\Admin\LoginAdminCommand;
use Illuminate\Support\Facades\Auth;

class LoginAdminHandler
{
    public function handle(LoginAdminCommand $command){

        if(Auth::guard('admin')->attempt(['email' => $command->email, 'password' => $command->password])){
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('MyApp',['admin'])->plainTextToken;
            return ['admin' => $admin, 'token' => $token];
        }
        return response()->json(['error' => 'Bad credits'], 402);


    }


}

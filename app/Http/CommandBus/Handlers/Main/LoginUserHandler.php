<?php

namespace App\Http\CommandBus\Handlers\Main;


use App\Http\CommandBus\Commands\Main\LoginUserCommand;
use App\Http\Resources\User\UserResourceMin;
use Illuminate\Support\Facades\Auth;

class LoginUserHandler
{
    public function handle(LoginUserCommand $command){

        if(Auth::guard('user')->attempt(['email' => $command->email, 'password' => $command->password])){
            $user = Auth::guard('user')->user();
            $token = $user->createToken('MyApp', ['user'])->plainTextToken;
            return ['user' => UserResourceMin::make($user), 'token' => $token];
        }
        return ['error' => 'Bad credits'];

    }
}

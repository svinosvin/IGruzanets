<?php

namespace App\Http\CommandBus\Handlers\Main;


use App\Http\CommandBus\Commands\Main\LoginUserCommand;
use Illuminate\Support\Facades\Auth;

class LoginUserHandler
{
    public function handle(LoginUserCommand $command){

        if(Auth::guard('user')->attempt(['email' => $command->email, 'password' => $command->password])){
            $user = Auth::guard('user')->user();
            $token = $user->createToken('MyApp', ['user'])->plainTextToken;
            return ['user' => $user, 'token' => $token];
        }
        return response()->json(['error' => 'Bad credits'], 402);

    }
}

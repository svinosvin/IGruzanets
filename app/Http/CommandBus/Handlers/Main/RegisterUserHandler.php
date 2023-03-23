<?php

namespace App\Http\CommandBus\Handlers\Main;

use App\Http\CommandBus\Commands\Main\RegisterUserCommand;
use App\Http\Resources\User\UserResourceMin;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class RegisterUserHandler
{
    public function handle(RegisterUserCommand $command){

        $user = User::create([
            'name' => $command->data['name'] ?? null,
            'first_name' => $command->data['first_name'] ?? null,
            'patronymic' => $command->data['patronymic'] ?? null,
            'email' => $command->data['email'],
            'password'=> Hash::make($command->data['password']),
            'tel_number' => $command->data['tel_number'],
        ]);

        $token = $user->createToken('MyApp', ['user'])->plainTextToken;
        return [
            'token' => $token,
            'user' => UserResourceMin::make($user),
        ];

    }
}

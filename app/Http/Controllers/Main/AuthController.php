<?php

namespace App\Http\Controllers\Main;

use App\Http\CommandBus\Commands\Main\RegisterUserCommand;
use App\Http\CommandBus\Handlers\Main\RegisterUserHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\LoginRequest;
use App\Http\Requests\Main\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\CommandBus\Commands\Main\LoginUserCommand;
use App\Http\CommandBus\Handlers\Main\LoginUserHandler;
class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginUserHandler $handler){

        $data = $request->validated();
        $command = new LoginUserCommand($data['email'], $data['password']);
        $response = $handler->handle($command);
        return response()->json($response, 201);
    }


    public function register(RegisterRequest $request, RegisterUserHandler $handler){

        $data = $request->validated();
        $command = new RegisterUserCommand($data);
        $response = $handler->handle($command);
        return response()->json($response, 201);
    }

    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Успешно вышли из учетной записи!',

        ]);
    }

    public function index(){
        return response()->json(['user' =>Auth::user() ], 201);

    }
}

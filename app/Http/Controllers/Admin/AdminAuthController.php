<?php

namespace App\Http\Controllers\Admin;

use App\Http\CommandBus\Commands\Admin\LoginAdminCommand;
use App\Http\CommandBus\Handlers\Admin\LoginAdminHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{

    public function login(LoginAdminRequest $request,  LoginAdminHandler $handler){

        $data = $request->validated();
        $command = new LoginAdminCommand($data['email'], $data['password']);
        $response = $handler->handle($command);
        return response()->json($response, 201);

    }

    public function logout(){
        $admin = Auth::user();
        $admin->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Успешно вышли из учетной записи!',
        ]);
    }

    public function index(){
        return response()->json(['admin' => Auth::user()], 201);
    }

}

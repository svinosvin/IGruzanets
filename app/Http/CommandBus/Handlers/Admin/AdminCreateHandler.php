<?php

namespace App\Http\CommandBus\Handlers\Admin;


use App\Http\CommandBus\Commands\Admin\AdminCreateCommand;
use App\Http\Resources\Admin\AdminFullResource;
use App\Models\Admin;
use Hash;
use Illuminate\Support\Facades\Auth;

class AdminCreateHandler
{
    public function handle(AdminCreateCommand $command){

        $admin = Admin::create([
            'name' => $command->data['name'] ?? null,
            'first_name' => $command->data['first_name'] ?? null,
            'patronymic' => $command->data['patronymic'] ?? null,
            'email' => $command->data['email'],
            'password'=> Hash::make($command->data['password']),
            'tel_number' => $command->data['tel_number'],
        ]);
        return [
          'admin' => AdminFullResource::make($admin),
          'message' => 'Successfully created'
        ];
    }


}

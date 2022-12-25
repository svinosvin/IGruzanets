<?php

namespace App\Http\CommandBus\Commands\Main;


use Illuminate\Console\Command;

class RegisterUserCommand
{

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}

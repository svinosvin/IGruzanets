<?php

namespace App\Http\CommandBus\Commands\Main;


use Illuminate\Console\Command;

class LoginUserCommand
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}

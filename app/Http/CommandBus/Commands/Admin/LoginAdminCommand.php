<?php

namespace App\Http\CommandBus\Commands\Admin;


use Illuminate\Console\Command;

class LoginAdminCommand
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}

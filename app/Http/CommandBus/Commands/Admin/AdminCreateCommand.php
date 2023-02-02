<?php

namespace App\Http\CommandBus\Commands\Admin;


use Illuminate\Console\Command;

class AdminCreateCommand
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}

<?php

namespace App\Http\CommandBus\Commands\Image;


use App\Models\Image;
use Illuminate\Console\Command;

class ImageRemoveCommand
{
    public string $imageUrl;

    public function __construct($imageUrl)
    {
        $this->imageUrl = $imageUrl;

    }

}

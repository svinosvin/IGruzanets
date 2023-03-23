<?php

namespace App\Http\CommandBus\Commands\Image;


use App\Models\Image;
use Illuminate\Console\Command;

class ImageAddCommand
{
    public string $image;
    public string $folder;

    public function __construct($image, $folder = Image::FOLDER_BASE)
    {
        $this->image = $image;
        $this->folder = $folder;

    }

}

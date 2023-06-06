<?php

namespace App\Http\CommandBus\Handlers\Image;


use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Http\CommandBus\Commands\Image\ImageRemoveCommand;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageRemoveHandler
{
    public function handle(ImageRemoveCommand $command){


      $imagePath = Image::where('path', $command->imageUrl)->first();
      if($imagePath){
          Storage::delete('public/'.$imagePath->path);
          return $imagePath->delete();
      }
      return false;
    }
}

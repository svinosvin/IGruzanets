<?php

namespace App\Http\CommandBus\Handlers\Image;


use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageAddHandler
{
    public function handle(ImageAddCommand $command){

      $existImage = Image::where('name', $command->image)->first();
      if(!$existImage){
          $path = Storage::disk('public')->put('/images/'.$command->folder, $command->image);
          $image = Image::firstOrCreate()([
              'path' => $path,
              'name' =>  $command->image,
          ]);
          return $image->path;
      }
      return null;
    }
}

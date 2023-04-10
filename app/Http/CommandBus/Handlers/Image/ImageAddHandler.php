<?php

namespace App\Http\CommandBus\Handlers\Image;


use App\Http\CommandBus\Commands\Image\ImageAddCommand;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageAddHandler
{
    public function handle(ImageAddCommand $command){

      $name = time().$command->image->getClientOriginalName();
      $existImage = Image::where('name', $name)->first();
      if(!$existImage){
          $path = Storage::disk('public')->put('/images/'.$command->folder, $command->image);
          $image = Image::firstOrCreate([
              'path' => $path,
              'name' => $name,
          ]);
          return $path;
      }
      return null;
    }
}

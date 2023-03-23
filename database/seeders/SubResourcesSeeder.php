<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\SubResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [];
        $file = fopen(base_path('database/data/subResources.csv'), 'r');
        if($file === false){
            die('Cannot open the file');
        }
        $header = fgetcsv($file, separator: ',');
        while (($row = fgetcsv($file, separator: ',')) !== false){

            SubResource::updateOrCreate([
                'title' => $row[0],
                'description' => $row[1] ?? '',
                'examples' => $row[2] ?? ''
            ]);
        }
        fclose($file);
    }
}

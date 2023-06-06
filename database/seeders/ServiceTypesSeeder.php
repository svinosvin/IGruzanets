<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [];
        $file = fopen(base_path('database/data/serviceTypes.csv'), 'r');
        if($file === false){
            die('Cannot open the file');
        }
        $header = fgetcsv($file, separator: ',');
        while (($row = fgetcsv($file, separator: ',')) !== false){
            ServiceType::updateOrCreate([
                'title' => $row[0],
            ]);
        }
        fclose($file);
    }
}

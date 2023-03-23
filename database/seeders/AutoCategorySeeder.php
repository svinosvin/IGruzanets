<?php

namespace Database\Seeders;

use App\Models\AutoCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [];
        $file = fopen(base_path("database/data/autoCategories.csv"),'r');
        if ($file === false) {
            die('Cannot open the file');
        }
        $header = fgetcsv($file, separator:  ",");
        while (($row = fgetcsv($file, separator:  ",")) !== false){
            AutoCategory::updateOrCreate([
                'title'=> $row[0],
                'description'=> $row[1],
            ]);
        }
        fclose($file);
    }
}

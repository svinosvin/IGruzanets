<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AutoCategory;
use App\Models\Driver;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Service::factory(10)->create();
        Driver::factory(13)->create();
        $this->call([
            AutoCategorySeeder::class,
            ResourcesSeeder::class,
            SubResourcesSeeder::class,
            OrderTypesSeeder::class,
            ServiceTypesSeeder::class,
        ]);

        $categories = AutoCategory::all();
        $drivers = Driver::all();
        $drivers->each(function ($driver) use ($categories) {
             $driver->auto_categories()->attach($categories->random(rand(0,5))->pluck('id')->toArray());
        });

        $data['name'] = 'Artem';
        $data['tel_number'] = '312321';
        $data['password'] = bcrypt(12345678);
        $data['email'] = 'a@bk.ru';

        Admin::create($data);

        $cdata['name'] = 'Artem';
        $cdata['tel_number'] = '312321';
        $cdata['password'] = bcrypt(12345678);
        $cdata['email'] = 'a@bk.ru';

        User::create($cdata);
    }
}

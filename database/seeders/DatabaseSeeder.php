<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $seeders = [
            UserSeeder::class,
            ProjectSeeder::class,
            TimesheetSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            ProjectUserSeeder::class,  
        ];

        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // In DatabaseSeeder.php
public function run()
{
    $this->call([
        TourSeeder::class,
        ActivitySeeder::class,
        TripSeeder::class,
    ]);
}

}

<?php

namespace Database\Seeders;

use Faker\Provider\Address;
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
        $this->call([
            AddressSeeder::class,
            HotelSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\RoomType;
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
            UsersSeeder::class,
            HotelSeeder::class,
            RoomTypesSeeder::class,
        ]);
    }
}

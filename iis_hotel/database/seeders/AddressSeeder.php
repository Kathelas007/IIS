<?php

namespace Database\Seeders;

use mysql_xdevapi\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Factory as Faker;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 1; $i <= 10; $i++){
            DB::table('addresses')->updateOrInsert([
                'ulice' => $faker->streetName,
                'c_popisne' => rand(1, 1000),
                'mesto' =>  $faker->city,
                'PSC' => rand(10000, 90000),
                'stat' =>  $faker->country
            ]);
        }

        for($i = 1; $i <= 10; $i++){
            DB::table('addresses')->updateOrInsert([
                'ulice' => $faker->streetName,
                'c_popisne' => rand(1, 1000),
                'mesto' => 'Brno' . Str::random(3),
                'PSC' => rand(10000, 90000),
                'stat' => $faker->country,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use mysql_xdevapi\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            DB::table('addresses')->updateOrInsert([
                'ulice' => Str::random(5),
                'c_popisne' => rand(1, 1000),
                'mesto' => Str::random(5),
                'PSC' => rand(10000, 99999),
                'stat' => Str::random(2),
            ]);
        }

        for($i = 1; $i <= 10; $i++){
            DB::table('addresses')->updateOrInsert([
                'ulice' => Str::random(5),
                'c_popisne' => rand(1, 1000),
                'mesto' => 'Brno' . Str::random(5),
                'PSC' => rand(10000, 99999),
                'stat' => Str::random(2),
            ]);
        }
    }
}

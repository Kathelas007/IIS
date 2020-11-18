<?php

namespace Database\Seeders;

use Faker\Factory;
use mysql_xdevapi\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models;


class HotelSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        for($i = 1; $i <= 20; $i++){
            DB::table('hotels')->updateOrInsert([
                'oznaceni' => 'hotel ' . Str::random(10),
                'popis' => Str::random(200),
            ]);
        }

        for($i = 1; $i <= 10; $i++){
            DB::table('hotels')->updateOrInsert([
                'oznaceni' => 'pension ' . Str::random(10),
                'popis' => Str::random(200),
                'address_id' => rand(1, 18),
            ]);
        }

    }
}

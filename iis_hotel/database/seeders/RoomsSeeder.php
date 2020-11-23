<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory;
use Faker\Provider\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
use Intervention\Image\ImageManagerStatic as Im;

class RoomsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $manesky = DB::table('hotels')
            ->select('id')
            ->where('oznaceni', '=', "Mánesovy koleje")
            ->first();

        $manesky_type = DB::table('room_types')
            ->select('id')
            ->where('hotel_id', '=', "$manesky->id")
            ->get();

        DB::table('rooms')->updateOrInsert([
            'number' => 7,
            'roomType_id' => $manesky_type[0]->id,
        ]);

    }
}

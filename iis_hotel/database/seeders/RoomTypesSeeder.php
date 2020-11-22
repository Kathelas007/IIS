<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory;
use Faker\Provider\Image;
use Intervention\Image\ImageManager;
use mysql_xdevapi\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
use Intervention\Image\ImageManagerStatic as Im;

use App\Models\Hotel;

class RoomTypesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // others
        $faker = Faker::create();
        $hotels = DB::table('hotels')
            ->where('oznaceni', '!=', 'Mánesovy koleje')
            ->select('id')
            ->get();

        $room_types_names = ['Business', 'Family', 'President apartman', 'Suite'];
        foreach ($hotels as $hotel) {
            $type_count = rand(1, count($room_types_names));
            $hotel_room_types = $faker->randomElements($room_types_names, $type_count, false);

            foreach ($hotel_room_types as $type) {
                DB::table('room_types')->updateOrInsert([
                    'name' => $type,
                    'beds_count' => rand(1, 5),
                    'equipment' => Str::random(20),
                    'price' => rand(200, 5000),
                    'hotel_id' => $hotel->id,
                ]);
            }
        }

        // manesky
        $manesky = DB::table('hotels')
            ->select('id')
            ->where('oznaceni', '=', "Mánesovy koleje")
            ->first();

        DB::table('room_types')->updateOrInsert([
            'name' => 'Jednolůžkový',
            'beds_count' => 1,
            'equipment' => 'postel, skříň, stůl, židle, lampička',
            'price' => 330,
            'hotel_id' => $manesky->id,
        ]);

        DB::table('room_types')->updateOrInsert([
            'name' => 'Dvoulůžkový',
            'beds_count' => 2,
            'equipment' => 'postel, skříň, stůl, židle, lampička',
            'price' => 300,
            'hotel_id' => $manesky->id,
        ]);

    }
}

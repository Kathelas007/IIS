<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Provider\Image;
use Intervention\Image\ImageManager;
use mysql_xdevapi\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
use Intervention\Image\ImageManagerStatic as Im;

use App\Models;


class HotelSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $manager = new ImageManager(array('driver' => 'imagick'));

//        $img = Im::make('https://picsum.photos/300/200')->resize(300, 200);
        $faker = Faker::create();


        DB::table('hotels')->updateOrInsert([
            'oznaceni' => 'Mánesovy koleje',
            'popis' => 'Nejlepší koleje v Brně',
            'user_id' => 1,
//            'image' => $img->encode('jpg', 80),
            'ulice' => $faker->streetName,
            'c_popisne' => $faker->streetAddress,
            'mesto' => $faker->city,
            'PSC' => $faker->postcode,
            'stat' => $faker->state,

        ]);

        for ($i = 1; $i <= 20; $i++) {
//            $img = Im::make('https://picsum.photos/300/200')->resize(300, 200);
            DB::table('hotels')->updateOrInsert([
                'oznaceni' => 'hotel ' . Str::random(10),
                'popis' => Str::random(200),
                'user_id' => 1,
                //            'image' => $img->encode('jpg', 80),
                'ulice' => $faker->streetName,
                'c_popisne' => $faker->streetAddress,
                'mesto' => $faker->city,
                'PSC' => $faker->postcode,
                'stat' => $faker->state,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('hotels')->updateOrInsert([
                'oznaceni' => 'pension ' . Str::random(10),
                'popis' => Str::random(200),
                'user_id' => 1,
                //            'image' => $img->encode('jpg', 80),
                'ulice' => $faker->streetName,
                'c_popisne' => $faker->streetAddress,
                'mesto' => "Brno",
                'PSC' => $faker->postcode,
                'stat' => $faker->state,
            ]);
        }

    }
}

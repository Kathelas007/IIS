<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Provider\Image;
use Intervention\Image\ImageManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
use Intervention\Image\ImageManagerStatic as Im;

use App\Models;


class HotelSeeder extends Seeder {
    private function get_and_save_image() {

        $image = Im::make('https://picsum.photos/400/400');
        $image->encode('png');
        $name = "seed" . '_' . time() . '.png';
        $folder = 'images/';
        $filePath = $folder . $name;
        $image->save('public/storage/' . $filePath);

        return $filePath;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker = Faker::create();
        $owners = DB::table('users')
            ->where('role', '=', Models\User::role_owner)
            ->select('id')
            ->get();

        $owner_ids = [];
        foreach ($owners as $owner) {
            array_push($owner_ids, $owner->id);
        }

        DB::table('hotels')->updateOrInsert([
            'oznaceni' => 'Mánesovy koleje',
            'popis' => 'Best dormitory in Brno',
            'user_id' => $faker->randomElement($owner_ids),
            'image' => 'images/manesky_640.jpg',
            'ulice' => 'Mánesova',
            'c_popisne' => 2556,
            'mesto' => "Brno-Královo Pole",
            'PSC' => '61200',
            'stat' => "Czech republick",
            'ucet' => " 932932932/0300",

        ]);

        for ($i = 1; $i <= 10; $i++) {
            DB::table('hotels')->updateOrInsert([
                'oznaceni' => 'hotel ' . Str::random(10),
                'popis' => Str::random(200),
                'user_id' => $faker->randomElement($owner_ids),
                'ulice' => $faker->streetName,
                'c_popisne' => rand(1, 1000),
                'mesto' => $faker->city,
                'PSC' => $faker->postcode,
                'stat' => $faker->state,
                'image' => $this->get_and_save_image(),
                'ucet' => $faker->bankAccountNumber,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            $img = null;
            if (rand(0, 9) > 7)
                $img = $this->get_and_save_image();
            DB::table('hotels')->updateOrInsert([
                'oznaceni' => 'pension ' . Str::random(10),
                'popis' => Str::random(200),
                'user_id' => $owner_ids[0],
                'ulice' => $faker->streetName,
                'c_popisne' => rand(1, 1000),
                'mesto' => "Brno",
                'PSC' => $faker->postcode,
                'stat' => $faker->state,
                'ucet' => $faker->bankAccountNumber,
            ]);
        }

    }
}

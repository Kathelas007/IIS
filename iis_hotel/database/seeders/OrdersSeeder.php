<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

use Faker\Factory;
use Faker\Provider\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
use Intervention\Image\ImageManagerStatic as Im;

use App\Models\Order;
use App\Models\Room;
use App\Http\Controllers\HotelController;


class OrdersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create();

        $date_s = date_create_from_format('j-m-Y', '01-01-2021');
        $date_e = date_create_from_format('j-m-Y', '02-01-2021');

        DB::table('orders')->updateOrInsert([
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'state' => $faker->state,
            'start_date' => $date_s,
            'end_date' => $date_e,
        ]);

        $order_id = DB::getPdo()->lastInsertId();
        $manesky = HotelController::get_hotel_by_oznaceni('Mánesovy koleje');
        $rooms_manesky = DB::table('room_types')
            ->join('rooms', 'room_types.id', '=', 'rooms.roomType_id')
            ->where('hotel_id', '=', $manesky->id)
            ->select('rooms.id AS room_id')
            ->first();


        DB::table('room_orders')->updateOrInsert([
            'room_id' => $rooms_manesky->room_id,
            'order_id' => $order_id
        ]);

    }
}

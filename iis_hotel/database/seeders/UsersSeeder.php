<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Faker\Provider\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
use Intervention\Image\ImageManagerStatic as Im;
use App\Models\User;

//const role_admin = 0;
//const role_owner = 10;
//const role_clerk = 20;
//const role_customer = 30;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insertOrIgnore([
            'firstname' => 'Joe',
            'lastname' => "Owner",
            'email' => 'owner@gmail.com',
            'password' => Hash::make("12345678"),
            'role' => User::role_owner
        ]);

        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insertOrIgnore([
                'firstname' => 'Joe',
                'lastname' => "Owner $i",
                'email' => "owner$i@gmail.com",
                'password' => Hash::make("12345678"),
                'role' => User::role_owner
            ]);
        }

        DB::table('users')->insertOrIgnore([
            'firstname' => 'Jack',
            'lastname' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("12345678"),
            'role' => User::role_admin
        ]);

        DB::table('users')->insertOrIgnore([
            'firstname' => 'Jill',
            'lastname' => 'Clerk',
            'email' => 'clerk@gmail.com',
            'password' => Hash::make("12345678"),
            'role' => User::role_clerk,
        ]);

        DB::table('users')->insertOrIgnore([
            'firstname' => 'Joe',
            'lastname' => 'Costumer',
            'email' => 'costumer@gmail.com',
            'password' => Hash::make("12345678"),
            'role' => User::role_customer,
        ]);

        DB::table('users')->insertOrIgnore([
            'firstname' => 'k',
            'lastname' => 'm',
            'email' => 'k@m.com',
            'password' => Hash::make("12345678"),
            'role' => User::role_customer,
        ]);
    }
}

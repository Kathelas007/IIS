<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use mysql_xdevapi\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use Intervention\Image\ImageManagerStatic as Im;

class HotelController extends Controller {
    public function index(Hotel $hotel) {
        $hotels = Hotel::All();

        $data = [
            'hotels' => $hotels,
        ];
        return view('hotels.index', $data);
    }

    public static function get_search_paginator($loc_pos) {

        $by_hotel = DB::table('hotels')->where('oznaceni', 'like', "%$loc_pos%")
            ->select('hotels.id', 'hotels.oznaceni');

        return DB::table('hotels')->join('addresses', function ($join) {
            $join->on('addresses.id', '=', 'hotels.address_id');
        })
            ->where('addresses.mesto', 'like', "%$loc_pos%")
            ->select('hotels.id', 'hotels.oznaceni')
            ->union($by_hotel)
            ->paginate(10);
    }

    function public_show($id) {
        $hotel = Hotel::findOrFail($id);
        $address = null;

        if ($hotel->address_id != null) {
            // TODO function from address model
            $address = DB::table('addresses')->where("id", '=', "$hotel->address_id")->first();
        }
        return view('hotels.public_show', ['hotel' => $hotel, 'address' => $address]);
    }


    function fetch_hotel_image($hotel_id) {
        // TODO

//        $hotel = Hotel::findOrFail($hotel_id);
//        $image_file = $hotel->image;
//        $response = Response::make($image_file->encode('jpg'));
//        $response->header('Content-Type', 'image/jpg');
//        return $response;


        $img = Im::make('https://picsum.photos/100/100')->resize(100, 100);
        return $img->response('jpg');
    }
}

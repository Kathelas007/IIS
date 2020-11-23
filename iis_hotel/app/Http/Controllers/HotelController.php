<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\ImageManagerStatic as Im;

class HotelController extends Controller {

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'oznaceni'  => ['required', 'string', 'max:255'],
            'popis'     => ['required', 'string'],
            //image
            'street'    => ['string', 'max:255'],
            'city'      => ['string', 'max:255'],
            'c_popisne' => ['digits_between:0,10'],
            'PSC'       => ['digits_between:0,10']
        ]);
    }

   /* public function __construct() {
        $this->middleware('auth');
    }*/

    public function index(User $user = NULL) {
       if ( $user != NULL){
            $hotels = Hotel::where('user_id', $user->id)->get();
        } else if (Auth::user()->isAtLeast(User::role_admin)) {
            $hotels = Hotel::All();
        } else {
            return redirect('home');
        }

        $data = [
            'hotels' => $hotels,
        ];
        return view('hotels.index', $data);
    }

    public static function get_search_paginator($loc_pos) {

        $by_hotel = DB::table('hotels')->where('oznaceni', 'like', "%$loc_pos%")
            ->select('hotels.id', 'hotels.oznaceni');

        return DB::table('hotels')
            ->where('mesto', 'like', "%$loc_pos%")
            ->select('hotels.id', 'hotels.oznaceni')
            ->union($by_hotel)
            ->paginate(10);

        /*return DB::table('hotels')->join('addresses', function ($join) {
            $join->on('addresses.id', '=', 'hotels.address_id');
        })
            ->where('addresses.mesto', 'like', "%$loc_pos%")
            ->select('hotels.id', 'hotels.oznaceni')
            ->union($by_hotel)
            ->paginate(10);*/
    }

    function public_show(Request $request) {
        $hotel = $request->session()->get('hotel');
        if(empty($hotel)) {
            $hotel = Hotel::findOrFail($request->hotel_id);
        }

        $types = RoomType::where('hotel_id', $hotel->id)->get();
        $room_types = array();
        foreach($types as $type) {
            $rooms_count = Room::where('roomType_id', $type->id)->count();
            // TODO: select only available rooms

            $room_types[] = [
                'type' => $type,
                'count' => $rooms_count,
            ];
        }

        $order = $request->session()->get('order');
        if(empty($order)) {
            $order = new Order();
        }
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $request->session()->put('order', $order);


        $data = [
            'order' => $order,
            'hotel' => $hotel,
            'room_types' => $room_types,
        ];
        return view('hotels.public_show', $data);
    }

    public function public_show_post(Request $request)
    {
        $room_types = array();
        foreach($request->room_types as $type_id => $count) {
            $room_types[] = [
                'type' => RoomType::findOrFail($type_id),
                'count' => $count,
            ];
        }

        $request->session()->put('room_types', $room_types);

        return redirect()->route('orders.create');
    }

    public function owner_show(Hotel $hotel) {

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel,
            'roomTypes' => RoomType::where('hotel_id', $hotel->id)->get()
        ];
        return view('hotels.owner_show', $data);
    }

    public function add(){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        return view('hotels.add');
    }

    public function store(Request $request){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $this->validator($request->all())->validate();

        $user = Auth::user();

        $hotel = new Hotel();
        $hotel->oznaceni = $request->oznaceni;
        $hotel->popis    = $request->popis;
        $hotel->ulice    = $request->ulice;
        $hotel->c_popisne = $request->c_popisne;
        $hotel->mesto     = $request->mesto;
        $hotel->PSC       = $request->PSC;
        $hotel->stat      = $request->stat;

        $hotel->user_id  = $user->id;
        $hotel->save();

        return redirect('home');
    }

    public function edit(Hotel $hotel){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel
        ];
        return view('hotels.edit', $data);
    }

    public function update(Request $request, Hotel $hotel){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $this->validator($request->all())->validate();

        $hotel->oznaceni = $request->oznaceni;
        $hotel->popis    = $request->popis;
        $hotel->ulice    = $request->ulice;
        $hotel->c_popisne = $request->c_popisne;
        $hotel->mesto     = $request->mesto;
        $hotel->PSC       = $request->PSC;
        $hotel->stat      = $request->stat;

        $hotel->save();

            return redirect('home');
        }

    public function destroy ($id){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect('/home');
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

    // TODO datepicker data
}

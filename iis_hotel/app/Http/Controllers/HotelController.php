<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Order;
use App\Models\User;
use App\Models\RoomType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\ImageManagerStatic as Im;
use function Psy\debug;

class HotelController extends Controller {

    protected function validator(array $data) {
        return Validator::make($data, [
            'oznaceni' => ['required', 'string', 'max:255'],
            'popis' => ['required', 'string'],
            //image
            'street' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'c_popisne' => ['digits_between:0,10'],
            'PSC' => ['digits_between:0,10']
        ]);
    }

    public function index(User $user = NULL) {

        if (Auth::user()->isAtLeast(User::role_admin)) {
            $hotels = Hotel::All();
        } else if (Auth::user()->isAtLeast(User::role_owner) && $user != NULL) {
            $hotels = Hotel::where('user_id', $user->id)->get();
        } else {
            return redirect('home');
        }

        $data = [
            'hotels' => $hotels,
        ];
        return view('hotels.index', $data);
    }


    private static function join_orders_to_hotel_direction($start, $end, $to_hotel) {

        $orders = DB::table('orders')->where([['end_date', '>=', "$start"], ['start_date', '<=', "$end"]]);

        if ($orders->get()->count() == 0)
            return null;

        $orders_joined = $orders
            ->join('order_room', 'order_room.order_id', '=', 'orders.id') //1
            ->join('rooms', 'rooms.id', 'order_room.room_id'); //2

        if ($to_hotel) {
            $orders_joined
                ->join('room_types', 'room_types.id', 'rooms.roomType_id') //3
                ->join('hotels', 'hotels.id', '=', 'room_types.hotel_id') //4
                ->select('hotels.id AS hotels_id', 'room_types.id AS room_type_id', 'rooms.id AS room_id');
        } else {
            $orders_joined->select('rooms.id AS rooms_id', 'rooms.roomType_id AS rooms_roomType_id');
        }

        return $orders_joined;
    }


    private static function get_available_room_types($hotel_id, $start_date, $end_date) {
        $all_room_types = DB::table('room_types')->where('hotel_id', '=', "$hotel_id");
        if ($all_room_types->get()->count() == 0) {
            return $all_room_types->get();
        }

        $orders_joined = HotelController::join_orders_to_hotel_direction($start_date, $end_date, false);

        $filtered_room_types = null;
        if ($orders_joined == null) {
            $filtered_room_types = $all_room_types->join('rooms', 'rooms.roomType_id', '=', 'room_types.id');
        } else {
            $hotels_orders_joined = $all_room_types->leftJoinSub($orders_joined, 'orders', function ($join) {
                $join->on('orders.rooms_id', '=', 'room_types.id');
            });
            $filtered_room_types = $hotels_orders_joined->whereNull('orders.rooms_id');
        }

        $all_room_types = $filtered_room_types
            ->select(
                'room_types.id AS id',
                'room_types.name AS name',
                'room_types.beds_count AS beds_count',
                'room_types.equipment AS equipment',
                'room_types.price AS price',
                DB::raw('count(rooms.id) as total'))
            ->groupBy('room_types.id')
            ->orderBy('room_types.id')
            ->get();

        return $all_room_types;
    }

    public static function get_search_paginator($loc_pos = null, $start, $end) {
        if ($loc_pos == null) {
            $all_hotels = DB::table('hotels')
                ->select('hotels.id', 'hotels.oznaceni');
        } else {
            $all_hotels = DB::table('hotels')
                ->where('mesto', 'like', "%$loc_pos%")
                ->orWhere('oznaceni', 'like', "%$loc_pos%")
                ->select('hotels.id', 'hotels.oznaceni');
        }

        if ($all_hotels->get()->count() == 0) {
            Log::info('no hotels found');
            return $all_hotels->paginate(10);
        }

        $orders_joined = HotelController::join_orders_to_hotel_direction($start, $end, true);
        if ($orders_joined == null) {
            return $all_hotels
                ->select('hotels.id AS id', 'hotels.oznaceni AS oznaceni')
                ->leftJoin('room_types', 'room_types.hotel_id', '=', 'hotels.id')
                ->whereNotNull('room_types.id')
                ->leftJoin('rooms', 'rooms.roomType_id', '=', 'room_types.id')
                ->whereNotNull('rooms.id')
                ->groupBy('hotels.id')
                ->paginate(10);
        }

        $hotels_orders_joined = $all_hotels->leftJoinSub($orders_joined, 'orders', function ($join) {
            $join->on('orders.hotels_id', '=', 'hotels.id');
        });


        $filtered_hotels = $hotels_orders_joined->whereNull('orders.hotels_id');

        return $filtered_hotels->paginate(10);

    }

    public static function get_hotel_by_oznaceni($oznaceni) {
        return Hotel::where('oznaceni', 'like', "%$oznaceni%")
            ->first();
    }

    function public_show(Request $request) {
        // TODO selected se musi resit jinak
        // zatim na nej kaslu

        $hotel_id = $request->hotel_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $selected = null;

        // back from orders
        // no requests
        if ($hotel_id == null) {
            $hotel_id = $request->session()->get('hotel_id');
            $start_date = $request->session()->get('start_date');
            $end_date = $request->session()->get('end_date');
            $selected = $request->session()->get('selected');
        }

        $hotel = Hotel::findOrFail($hotel_id);

        $all_room_types = HotelController::get_available_room_types(
            $hotel_id, $start_date, $end_date);

        if ($selected == null) {
            $selected = [];
            foreach ($all_room_types as $room_type) {
                array_push($selected, 0);
            }
        }

        $order = $request->session()->get('order');
        if (empty($order)) {
            $order = new Order();
        }
        $order->start_date = $start_date;
        $order->end_date = $end_date;

        $request->session()->put('order', $order);
        $request->session()->put('selected', $selected);
        $request->session()->put('hotel_id', $hotel_id);
        $request->session()->put('start_date', $start_date);
        $request->session()->put('end_date', $end_date);
        $request->session()->put('selected', $selected);


        $data = [
            'order' => $order,
            'hotel' => $hotel,
            'room_types' => $all_room_types,
            'selected' => $selected
        ];

        return view('hotels.public_show', $data);
    }

    public function public_show_post(Request $request) {
        $room_types = array();
        foreach ($request->room_types as $type_id => $count) {
            $room_types[] = [
                'type' => RoomType::findOrFail($type_id),
                'count' => $count,
            ];
        }

        $request->session()->put('room_types', $room_types);

        return redirect()->route('orders.create');
    }

    private function get_assigned_clerks($hotelId = null) {
        if ($hotelId == NULL) {
            return DB::table('users')->join('hotel_clerk', 'users.id', '=', 'hotel_clerk.user_id')
                ->where('users.role', User::role_clerk)
                ->select('hotel_clerk.id', 'hotel_clerk.user_id', 'users.lastname','users.firstname', 'users.email')
                ->get();
        } else {

            return DB::table('users')->join('hotel_clerk', 'users.id', '=', 'hotel_clerk.user_id')
                ->where('users.role', User::role_clerk)
                ->where('hotel_clerk.hotel_id', $hotelId)
                ->select('hotel_clerk.id', 'hotel_clerk.user_id', 'users.lastname', 'users.firstname', 'users.email')
                ->get();
        }
    }

    private function get_clerks_except($hotelId) {

        $ignore = DB::table('hotel_clerk')
            ->where('hotel_id', $hotelId)
            ->select('user_id')
            ->get();

        $query = DB::table('users')->where('role', User::role_clerk);

        foreach ($ignore as $ignoreId) {
            $query = $query->where('id', '<>', $ignoreId->user_id);
        }

        return $query->get();
    }

    public function clerk_choose(Hotel $hotel) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel,
            'clerks' => $this->get_clerks_except($hotel->id)
        ];

        return view('hotels.clerk_choose', $data);
    }

    public function clerk_assign(Request $request, Hotel $hotel) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        foreach ($request->clerks as $selected) {

            DB::table('hotel_clerk')->insert(['hotel_id' => $hotel->id, 'user_id' => $selected]);

        }

        return redirect(route('hotels.owner_show', $hotel));
    }

    public function clerk_unassign(Hotel $hotel, $id) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        DB::table('hotel_clerk')->where('id', $id)->delete();

        return redirect(route('hotels.owner_show', $hotel));
    }

    public function owner_show(Hotel $hotel) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel,
            'roomTypes' => RoomType::where('hotel_id', $hotel->id)->get(),
            'clerks' => $this->get_assigned_clerks($hotel->id)
        ];
        return view('hotels.owner_show', $data);
    }

    public function add() {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        return view('hotels.add');
    }

    public function store(Request $request) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        $this->validator($request->all())->validate();

        $user = Auth::user();

        $hotel = new Hotel();
        $hotel->oznaceni = $request->oznaceni;
        $hotel->popis = $request->popis;
        $hotel->ulice = $request->ulice;
        $hotel->c_popisne = $request->c_popisne;
        $hotel->mesto = $request->mesto;
        $hotel->PSC = $request->PSC;
        $hotel->stat = $request->stat;

        $hotel->user_id = $user->id;
        $hotel->save();

        return redirect(route('hotels.owner_show', $hotel));
    }

    public function edit(Hotel $hotel) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel
        ];
        return view('hotels.edit', $data);
    }

    public function update(Request $request, Hotel $hotel) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        $this->validator($request->all())->validate();

        $hotel->oznaceni = $request->oznaceni;
        $hotel->popis = $request->popis;
        $hotel->ulice = $request->ulice;
        $hotel->c_popisne = $request->c_popisne;
        $hotel->mesto = $request->mesto;
        $hotel->PSC = $request->PSC;
        $hotel->stat = $request->stat;

        $hotel->save();

        return redirect(route('hotels.owner_show', $hotel));
    }

    public function destroy($id) {

        if (!(Auth::user()->isAtLeast(User::role_owner))) {
            return redirect('home');
        }

        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect(route('hotels.index', Auth::user()));
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

<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'number' => ['required','digits_between:1,3'],
        ]);
    }

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Hotel $hotel, RoomType $roomType = NULL)
    {
        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        if ($roomType != NULL){
            $rooms = Room::join('room_types','room_types.id', '=', 'rooms.roomType_id')
            ->where('room_types.id', $roomType->id)
            ->get(['rooms.id','rooms.number','room_types.name']);

        }
        else{

            $rooms = Room::join('room_types','room_types.id', '=', 'rooms.roomType_id')
            ->where('room_types.hotel_id', $hotel->id)
            ->get(['rooms.id','rooms.number','room_types.name']);
        }

        $data = [
            'hotel' => $hotel,
            'rooms' => $rooms
        ];

        return view('rooms.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Hotel $hotel)
    {
        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $roomTypes = RoomType::where('hotel_id', $hotel->id)->get();
        $data = [
            'hotel'     => $hotel,
            'roomTypes' => $roomTypes
        ];

        return view ('rooms.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Hotel $hotel)
    {
        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $this->validator($request->all())->validate();
        $request->validate([
            'number' => [Rule::unique('rooms','number')
            ->where(function($query) use ($request) {
                return $query->where('hotel_id', $request->hotel_id);
            })],
            ]);

        $room = new Room();
        $room->number = $request->number;
        $room->hotel_id = $request->hotel_id;
        $room->roomType_id = $request->type_id;

        $room->save();
        return redirect(route('rooms.index', $hotel));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel, Room $room)
    {
        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $roomTypes = RoomType::where('hotel_id', $hotel->id)->get();
        $data = [
            'hotel' => $hotel,
            'roomTypes' => $roomTypes,
            'room' => $room
        ];

        return view('rooms.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel, Room $room)
    {
        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $this->validator($request->all())->validate();
        $request->validate([
            'number' => [Rule::unique('rooms','number')
            ->where(function($query) use ($request, $room) {
                return $query->where('hotel_id', $request->hotel_id)
                        ->where('rooms.id','<>',$room->id);
            })],
            ]);

        $room->number = $request->number;
        $room->roomType_id = $request->type_id;

        $room->save();
        return redirect(route('rooms.index',$hotel));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */

    public function can_delete_room($id){

        Room::findOrFail($id);
        $orders = Order::join('order_room', 'order_room.order_id','=', 'orders.id')
                  ->where('order_room.room_id', $id)
                  ->whereNotIn('orders.state',['cancelled', 'finished'])
                  ->select('orders.*')
                  ->get();
        return (!(count($orders) > 0));
    }

    public function delete_room($id){
        $room = Room::findOrFail($id);
        Order::join('order_room', 'order_room.order_id', '=', 'orders.id')
               ->where('order_room.room_id', $id)
               ->select('orders.*')->delete();

        $room->delete();
    }

    public function destroy(Hotel $hotel, $id)
    {
        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        Room::findOrFail($id);
        if ($this->can_delete_room($id) == false){
            return redirect(route('hotels.owner_show', $hotel));
        }

        $this->delete_room($id);
        return redirect(route('rooms.index', $hotel));
    }
}

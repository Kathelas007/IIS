<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        if ($roomType != NULL){
            $rooms = Room::join('room_types','room_types.id', '=', 'rooms.roomType_id')
            ->where('room_types.id', $roomType->id)
            ->get(['rooms.id','rooms.number','room_types.name']);

        }
        else{

            $rooms = Room::join('room_types','room_types.id', '=', 'rooms.roomType_id')
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
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $room = new Room();
        $room->number = $request->number;
        $room->roomType_id = $request->type_id;

        $room->save();
        return redirect('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect('home');
    }
}
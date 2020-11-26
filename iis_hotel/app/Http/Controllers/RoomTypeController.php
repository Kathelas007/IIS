<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\user;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomTypeController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:127'],
            'beds_count'=> ['required', 'digits_between:1,2'],
            'price'     => ['required','digits_between:1,16'],
        ]);
    }

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Hotel $hotel) {

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $roomTypes = RoomType::where('hotel_id', $hotel->id)->get();

        $data = [
            'roomTypes' => $roomTypes
        ];

        return view('roomTypes.index', $data);
    }

    public function create(Hotel $hotel){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel
        ];
        return view('roomTypes.create',$data);
    }

    public function store(Request $request, Hotel $hotel){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $this->validator($request->all())->validate();

        $roomType = new RoomType();
        $roomType->name = $request->name;
        $roomType->beds_count = $request->beds_count;
        $roomType->equipment  = $request->equipment;
        $roomType->price      = $request->price;

        $roomType->hotel_id   = $hotel->id;
        $roomType->save();

        return redirect(route('hotels.owner_show', $hotel));
    }

    public function edit (Hotel $hotel, RoomType $roomType){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $data = [
            'hotel' => $hotel,
            'roomType' => $roomType
        ];

        return view('roomTypes.edit', $data);
    }

    public function update (Request $request, Hotel $hotel, RoomType $roomType){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $this->validator($request->all())->validate();

        $roomType->name = $request->name;
        $roomType->beds_count = $request->beds_count;
        $roomType->equipment  = $request->equipment;
        $roomType->price      = $request->price;

        $roomType->save();

        return redirect(route('hotels.owner_show', $hotel));
    }

    public function destroy ($id){

        if (! (Auth::user()->isAtLeast(User::role_owner))){
            return redirect('home');
        }

        $roomType = RoomType::findOrFail($id);
        $rooms = Room::where('roomType_id',$id)->get();

        foreach($rooms as $room){
            if( RoomController::can_delete_room($room->id) == false){
                return redirect('home');
            }
        }

        foreach($rooms as $room){
            RoomController::delete_room($room->id);
        }

        $roomType->delete();

        return redirect('home');
    }
}

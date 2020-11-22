<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
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
            'beds_count'=> ['digits_between:0,2'],
            'equipment' => ['required', 'string'],
            'price'     => ['required','digits_between:0,16'],
        ]);
    }

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Hotel $hotel) {

        $roomTypes = RoomType::where('hotel_id', $hotel->id)->get();

        $data = [
            'roomTypes' => $roomTypes
        ];

        return view('roomTypes.index', $data);
    }

    public function create(Hotel $hotel){

        $data = [
            'hotel' => $hotel
        ];
        return view('roomTypes.create',$data);
    }

    public function store(Request $request, Hotel $hotel){

        $this->validator($request->all())->validate();

        $roomType = new RoomType();
        $roomType->name = $request->name;
        $roomType->beds_count = $request->beds_count;
        $roomType->equipment  = $request->equipment;
        $roomType->price      = $request->price;

        $roomType->hotel_id   = $hotel->id;
        $roomType->save();

        return redirect('home');
    }

    public function destroy ($id){

        $roomType = RoomType::findOrFail($id);
        $roomType->delete();

        return redirect('home');
    }
}

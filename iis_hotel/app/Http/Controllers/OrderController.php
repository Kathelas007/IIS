<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Order;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller {

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'e-mail' => ['required', 'string', 'email', 'max:255'],
            //'phone' => ['digits:9'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user = NULL) {
        /*if($user != NULL) {
            $orders = Order::where('user_id', $user->id)->get();
        } else if(Auth::user()->isAtLeast(User::role_clerk)) {
            $orders = Order::all();
        } else {
            return redirect('home');
        }*/

        if (Auth::user()->isAtLeast(User::role_clerk)) {
            if ($user != NULL) {
                $orders = Order::where('user_id', $user->id)->get();
            } else {
                $orders = Order::all();
            }
        } else if (Auth::check()) {
            $orders = Order::where('user_id', Auth::user()->id)->get();
        } else {
            return redirect('home');
        }

        $data = [
            'orders' => $orders,
        ];
        return view('orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $order = $request->session()->get('order');
        $hotel_id = $request->session()->get('hotel_id');
        $room_types = $request->session()->get('room_types');

        $hotel = Hotel::where('id', '=', $hotel_id);

        if (empty($order) || empty($hotel) || empty($room_types)) {
            return redirect('/');
        }

        $selected = [];
        foreach ($room_types as $room_type) {
            array_push($selected, $room_type['count']);
        }

        $request->session()->put('selected', $selected);

        return view('orders.create', compact('order', 'hotel', 'room_types'));
    }

    public function create_post(Request $request) {
        $this->validator($request->all())->validate();

        $order = $request->session()->get('order');
        if (empty($order)) {
            return redirect('/');
        }

        $order->firstname = $request->firstname;
        $order->lastname = $request->lastname;
        $order->email = request('e-mail');
        $order->phone = $request->phone;
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        }
        $order->state = 'filed';
        $request->session()->put('order', $order);

        return redirect()->route('orders.summary');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $order = $request->session()->get('order');
        $room_types = $request->session()->get('room_types');
        if (empty($order) || empty($room_types)) {
            return redirect('/');
        }

        $rooms = new Collection();
        foreach ($room_types as $room_type) {
            // TODO: select only available rooms
            $rooms = $rooms->merge(Room::where('roomType_id', $room_type['type']->id)->get()->take($room_type['count']));
        }

        if ($order->save()) {
            $order->rooms()->attach($rooms);
        }

        $request->session()->forget('order');
        $request->session()->forget('hotel');
        $request->session()->forget('room_types');

        if (Auth::check()) {
            return redirect('home');
        } else {
            return redirect('register')
                ->with('firstname', $order->firstname)
                ->with('lastname', $order->lastname)
                ->with('email', $order->email);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order) {
        $data = [
            'order' => $order,
        ];
        return view('orders.show', $data);
    }

    public function summary(Request $request) {
        $order = $request->session()->get('order');
        $hotel = $request->session()->get('hotel');
        $room_types = $request->session()->get('room_types');

        return view('orders.summary', compact('order', 'hotel', 'room_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order) {
        if (!(Auth::user()->isAtLeast(User::role_clerk))) {
            return redirect('home');
        }

        $order->state = $request->state;

        $order->save();

        return redirect('/orders');
    }
}

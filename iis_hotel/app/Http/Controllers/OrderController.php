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
            'phone' => ['digits_between:0,9'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user = NULL) {

        if ($user != NULL && ($user->id == Auth::user()->id || Auth::user()->isAtLeast(User::role_admin))) {
            $orders = Order::where('user_id', $user->id)->get();
        } else if ($user == NULL && Auth::user()->isAtLeast(User::role_clerk)) {
            $orders = Order::join('hotel_clerk', 'hotel_clerk.hotel_id', '=', 'orders.hotel_id')
                ->where('hotel_clerk.user_id', Auth::user()->id)->select('orders.*')->get();
        } else {
            return redirect('/');
        }

        $data = [
            'user' => $user,
            'orders' => $orders,
            'filter' => 'all'
        ];
        return view('orders.index', $data);
    }

    public function filter(Request $request, User $user = NULL) {

        if ($user != NULL && ($user->id == Auth::user()->id || Auth::user()->isAtLeast(User::role_admin))) {
            $orders = Order::where('user_id', $user->id)->get();
        } else if ($user == NULL && Auth::user()->isAtLeast(User::role_clerk)) {
            $orders = Order::join('hotel_clerk', 'hotel_clerk.hotel_id', '=', 'orders.hotel_id')
                ->where('hotel_clerk.user_id', Auth::user()->id)->select('orders.*')->get();
        } else {
            return redirect('/');
        }

        $data = [
            'user' => $user,
            'orders' => $orders,
            'filter' => $request->filter
        ];
        return view('orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Request $request) {
        $order = $request->session()->get('order');
        $hotel_id = $request->session()->get('hotel_id');
        $room_types = $request->session()->get('room_types');

        $hotel = Hotel::where('id', '=', $hotel_id)->first();
        $hotel_oznaceni = $hotel->oznaceni;

        if (empty($order) || empty($hotel) || empty($room_types)) {
            return redirect('/');
        }

        $selected = [];
        foreach ($room_types as $room_type) {
            array_push($selected, $room_type['count']);
        }

        $request->session()->put('selected', $selected);

        return view('orders.create', compact('hotel_oznaceni', 'order',  'room_types'));
    }

    public function create_post(Request $request) {
        $this->validator($request->all())->validate();

        $order = $request->session()->get('order');
        if (empty($order)) {
            return redirect('/');
        }

        $order->hotel_id = $request->session()->get('hotel_id');
        $order->firstname = $request->firstname;
        $order->lastname = $request->lastname;
        $order->email = request('e-mail');
        $order->phone = $request->phone;
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        }
        $order->state = 'filed';
        $request->session()->put('order', $order);

        $hotel = Hotel::where('id', '=', $order->hotel_id)->first();

        return redirect()->route('orders.summary')->with(['hotel_name' => $hotel->oznaceni]);
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
            $new_rooms = HotelController::get_available_rooms($room_type['type']->id, $room_type['count'], $order->start_date, $order->end_date);
            $rooms = $rooms->merge($new_rooms);
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

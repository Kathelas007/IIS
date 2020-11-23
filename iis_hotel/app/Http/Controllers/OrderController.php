<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    /*public function __construct() {
        $this->middleware('auth');
    }*/

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'e-mail' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['digits:9'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user = NULL)
    {
        if($user != NULL) {
            $orders = Order::where('user_id', $user->id)->get();
        } else if(Auth::user()->isAtLeast(User::role_clerk)) {
            $orders = Order::all();
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
    public function create(Request $request)
    {
        $rooms = new Collection();
        foreach($request->room_types as $type => $count) {
            // TODO: select only available rooms
            $rooms = $rooms->merge(Room::where('roomType_id', $type)->get()->take($count));
        }

        $data = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rooms' => $rooms,
        ];

        return view('orders.create', $data);
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

        $order = new Order();
        $order->firstname = $request->firstname;
        $order->lastname = $request->lastname;
        $order->email = request('e-mail');
        $order->phone = $request->phone;
        $order->user_id = Auth::user()->id;
        $order->state = 'filed';
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;

        $order->save();

        foreach($request->rooms as $id) {
            $room_order = new RoomOrder();
            $room_order->room_id = $id;
            $room_order->order_id = $order->id;

            $room_order->save();
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $data = [
            'order' => $order,
        ];
        return view('orders.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->state = $request->state;

        $order->save();

        return redirect('/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

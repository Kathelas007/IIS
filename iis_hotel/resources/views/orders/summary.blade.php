@extends('layouts.app')

@section('content')
{{--    {{ dd(get_defined_vars()) }}--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card mt-3">
                    <div class="card-header">Order summary for {{session()->get('hotel_name')}}</div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-8">
                                        <div><b>Room type</b></div>
                                    </div>

                                    <div class="col-2">
                                        <b>Quantity</b>
                                    </div>

                                    <div class="col-2">
                                        <b>Price</b>
                                    </div>
                                </div>
                            </li>

                            @foreach ($room_types as $room_type)
                                @if( $room_type['count'] > 0)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-8">
                                                <div>{{ $room_type['type']->name }}</div>
                                            </div>

                                            <div class="col-2">
                                                {{ $room_type['count']}}
                                            </div>

                                            <div class="col-2">
                                                {{ $room_type['type']->price * $room_type['count'] }}
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach

                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-8">
                                        <div><b>TOTAL</b></div>
                                    </div>
                                    <div class="col-2">
                                        <b>{{ \App\Models\Order::totalCount($room_types) }}</b>
                                    </div>
                                    <div class="col-2">
                                        <b>{{ \App\Models\Order::totalPrice($room_types) }}</b>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">Personal details summary</div>

                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                <div class="col-4 text-right">
                                    First name:
                                </div>
                                <div class="col-6">
                                    {{ $order->firstname }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-right">
                                    Last name:
                                </div>
                                <div class="col-6">
                                    {{ $order->lastname }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-right">
                                    E-mail:
                                </div>
                                <div class="col-6">
                                    {{ $order->email }}
                                </div>
                            </div>
                            @isset($order->phone)
                                <div class="row">
                                    <div class="col-4 text-right">
                                        Phone number:
                                    </div>
                                    <div class="col-6">
                                        {{ $order->phone }}
                                    </div>
                                </div>
                            @endisset
                        </div>

                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">Payment details</div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                <div class="col-4 text-right">
                                    Bank account:
                                </div>
                                <div class="col-6">
                                    account
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-right">
                                    Variable symbol:
                                </div>
                                <div class="col-6">
                                    symbol
                                </div>
                            </div>

                            <div class="row m-3">
                                    <b>Full price has to be paid at least 3 days before check-in date.</b>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('orders.create') }}" class="btn btn-secondary">
                                    Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

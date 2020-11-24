@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Order summary</div>

                    <div class="card-body">
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

                    <div class="row">
                        <div class="col-md-4 text-right">
                            From date
                        </div>
                        <div class="col-md-6">
                            {{ $order->start_date->format('Y-m-d') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-right">
                            To date
                        </div>
                        <div class="col-md-6">
                            {{ $order->end_date->format('Y-m-d') }}
                        </div>
                    </div>

                    @foreach ($room_types as $room_type)
                        <div class="row">
                            <div class="col-3 text-right">
                                Room:
                            </div>
                            <div class="col-2">
                                {{ $room_type['type']->name }}
                            </div>
                            <div class="col-2 text-right">
                                Quantity:
                            </div>
                            <div class="col-1">
                                {{ $room_type['count']}}
                            </div>
                            <div class="col-2 text-right">
                                Total price:
                            </div>
                            <div class="col-1">
                                {{ $room_type['type']->price * $room_type['count'] }}
                            </div>
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-7 text-right">
                            Total quantity:
                        </div>
                        <div class="col-1">
                            {{ \App\Models\Order::totalCount($room_types) }}
                        </div>
                        <div class="col-2 text-right">
                            Full price:
                        </div>
                        <div class="col-1">
                            {{ \App\Models\Order::totalPrice($room_types) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <b>Full price has to be paid at least 3 days before check-in date.</b>
                        </div>
                    </div>

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

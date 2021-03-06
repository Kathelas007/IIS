@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Order</div>

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

                        <div class="row">
                            <div class="col-md-4 text-right">
                                Hotel:
                            </div>
                            <div class="col-md-6">
                                {{ $hotel->oznaceni }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                From date:
                            </div>
                            <div class="col-md-6">
                                {{ $order->start_date->format('Y-m-d') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                To date:
                            </div>
                            <div class="col-md-6">
                                {{ $order->end_date->format('Y-m-d') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                Account:
                            </div>
                            <div class="col-md-6">
                                {{ $hotel->ucet }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                Variable number:
                            </div>
                            <div class="col-md-6">
                                {{ $order->var_num}}
                            </div>
                        </div>

                        @authAtLeast(Auth::user()::role_clerk)
                        <form method="POST" action="{{ route('orders.update', $order) }}">
                            @csrf


                            <div class="form-group row">
                                <div class="col-4 text-right">
                                    Rooms
                                </div>
                                <div class="col-4">
                                    @foreach($order->rooms()->get() as $room)
                                        {{ $room->number }}
                                        @if(!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="state" class="col-md-4 col-form-label text-md-right">State</label>

                                <div class="col-md-6">
                                    <select name="state" id="state" class="form-control">
                                        @foreach (\App\Models\Order::states as $state)
                                            @if ($state == $order->state)
                                                <option value="{{ $state}}" selected>{{ $state }}</option>
                                            @else
                                                <option value="{{ $state }}">{{ $state }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change
                                    </button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </form>
                        @else
                            <a href="{{ route('orders.index', Auth::user()) }}">Back</a>
                            @endauthAtLeast
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

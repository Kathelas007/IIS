@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Orders</div>

                <div class="card-body">
                    @foreach ($orders as $order)
                        <div class="row">
                            <div class="col-4 text-right" >
                                {{ $order->firstname }} {{ $order->lastname }}:
                            </div>
                            <div class="col-4">
                                {{ $order->state }}
                            </div>
                            <div class="col-4">
                                <a href="{{ route('orders.show', $order) }}">Show</a>
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ route('orders.create') }}">Create</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="{{ route('orders.filter', $user) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="state" class="col-md-2 col-form-label text-md-left">Orders</label>

                            <div class="col-md-6 text-md-center">
                                <select name="filter" id="filter" class="form-control">
                                    @if ($filter == 'all')
                                        <option value="all" selected>All</option>
                                    @else
                                        <option value="all">All</option>
                                    @endif
                                    @foreach (\App\Models\Order::states as $state)
                                        @if ($filter == $state)
                                            <option value="{{ $state }}" selected>{{ $state }}</option>
                                        @else
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col text-left">
                                <button type="submit" class="btn btn-primary">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    @foreach ($orders as $order)
                        @if ($order->state == $filter || $filter == 'all')
                            <div class="row mt-1">
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
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

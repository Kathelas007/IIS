@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Orders</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-right">
                            First name:
                        </div>
                        <div class="col-6" >
                            {{ $order->firstname }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            Last name:
                        </div>
                        <div class="col-6" >
                            {{ $order->lastname }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            Phone number:
                        </div>
                        <div class="col-6" >
                            {{ $order->phone }}
                        </div>
                    </div>
                    @authAtLeast(Auth::user()::role_clerk)
                        <form method="POST" action="{{ route('orders.edit', $order) }}">
                            @csrf

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
                    @endauthAtLeast
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

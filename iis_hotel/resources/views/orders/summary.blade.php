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
                            E-mail:
                        </div>
                        <div class="col-6" >
                            {{ $order->email }}
                        </div>
                    </div>
                    @isset($order->phone)
                        <div class="row">
                            <div class="col-4 text-right">
                                Phone number:
                            </div>
                            <div class="col-6" >
                                {{ $order->phone }}
                            </div>
                        </div>
                    @endisset
                </div>

                <div class="row">
                    <div class="col-md-4 text-right">
                        From
                    </div>
                    <div class="col-md-6">
                        {{ $order->start_date }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right">
                    To
                </div>
                <div class="col-md-6">
                    {{ $order->end_date }}
                </div>
            </div>
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Confirm
                        </button>
                        <a href="{{ route('orders.create') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

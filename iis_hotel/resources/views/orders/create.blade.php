@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">File order</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('orders.create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="firstname" class="col-4 col-form-label text-right">First name</label>

                            <div class="col-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ $order->firstname }}" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-4 col-form-label text-right">Last name</label>

                            <div class="col-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ $order->lastname }}" required>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="e-mail" class="col-4 col-form-label text-right">E-mail</label>

                            <div class="col-6">
                                <input id="e-mail" type="text" class="form-control @error('e-mail') is-invalid @enderror" name="e-mail"
                                    @isset($order->email)
                                        value="{{ $order->email }}"
                                    @else
                                        @auth
                                            value="{{ Auth::user()->email }}"
                                        @else
                                            value=""
                                        @endauth
                                    @endisset
                                >

                                @error('e-mail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-4 col-form-label text-right">Phone number</label>

                            <div class="col-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $order->phone }}">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Next
                                </button>
                                <a href="{{ route('hotels.public_show') }}" class="btn btn-secondary">
                                    Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

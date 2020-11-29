@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">

                <form method="POST" action="{{ route('orders.create') }}">
                    @csrf
                    <div class="card mt-3">

                        {{-- Personal details --}}
                        <div class="card-header">Personal details {{$hotel_oznaceni}}</div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="firstname" class="col-4 col-form-label text-right reqlabel">First name</label>

                                <div class="col-6">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                        @isset($order->firstname)
                                            value="{{ $order->firstname }}"
                                        @else
                                            @auth
                                                value="{{ Auth::user()->firstname }}"
                                            @else
                                                value=""
                                            @endauth
                                        @endisset
                                    required autofocus>

                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-4 col-form-label text-right reqlabel">Last name</label>

                                <div class="col-6">
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                        @isset($order->lastname)
                                            value="{{ $order->lastname }}"
                                        @else
                                            @auth
                                                value="{{ Auth::user()->lastname }}"
                                            @else
                                                value=""
                                            @endauth
                                        @endisset
                                    required>

                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="e-mail" class="col-4 col-form-label text-right reqlabel">E-mail</label>

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
                                    required>

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
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ $order->phone }}">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 text-right">
                                    From date
                                </div>
                                <div class="col-md-6">
                                    {{ $order->start_date->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 text-right">
                                    To date
                                </div>
                                <div class="col-md-6">
                                    {{ $order->end_date->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('hotels.public_show') }}" class="btn btn-secondary">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Next
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                @include('components.required_note')
            </div>
        </div>
    </div>
@endsection

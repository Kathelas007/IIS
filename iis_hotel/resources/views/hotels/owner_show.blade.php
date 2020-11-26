@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    {{--card header                    --}}
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 text-left">
                                <h3> {{ $hotel->oznaceni}} </h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('hotels.edit', $hotel) }}">
                                    <button class="btn btn-primary">
                                        Edit hotel
                                    </button>
                                </a>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('rooms.index', $hotel) }}">
                                    <button class="btn btn-primary">
                                        Show rooms
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{--card body--}}
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-4">
                                        @if($hotel->image == null)
                                            <img src="{{ asset('storage/images/default.png')}}"
                                                 width="200" height="200"/>
                                        @else
                                            <img src="{{ asset('storage/' . $hotel->image)}}"
                                                 width="200" height="200"/>
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <h4>Description</h4>
                                        <p>{{$hotel->popis}}</p>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-6 text-right">
                                        <div class="row">
                                            <h4>Address</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-left">
                                                Country:
                                            </div>
                                            <div class="col-6 text-left">
                                                {{ $hotel->stat }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-left">
                                                City:
                                            </div>
                                            <div class="col-6 text-left">
                                                {{ $hotel->mesto }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-left">
                                                Street, no.:
                                            </div>
                                            <div class="col-6 text-left">
                                                {{ $hotel->ulice }}
                                                @if ($hotel->ulice != null && $hotel->c_popisne != null)
                                                    ,
                                                @endif
                                                {{ $hotel->c_popisne }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-left">
                                                Postal code:
                                            </div>
                                            <div class="col-6 text-left">
                                                {{ $hotel->PSC }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <div class="row">
                                            <h4>Account</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-left">
                                                Account number:
                                            </div>
                                            <div class="col-6 text-left">
                                                {{ $hotel->ucet}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        @include('hotels.hotel_clerks_index', ['hotel' => $hotel, 'clerks' => $clerks])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-left">
                        @include('roomTypes.index', ['roomTypes' => $roomTypes])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

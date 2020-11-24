@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 text-left">
                        Hotel Detail
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-7 text-left">
                           <h1>{{ $hotel->oznaceni}}</h1>
                        </div>
                        <div class="col-4 text-right">
                            <img src="/fetch_hotel_image/{{ $hotel->id }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7 text-left">
                            <div class="row">
                                <div class="col">
                                    <h2>Description<h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{ $hotel->popis }}
                                </div>
                            </div>
                        </div>
                        <div class="col-5 text-right">
                            <div class="row">
                                <h2>Address</h2>
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
                                    {{ $hotel->ulice }}, {{ $hotel->c_popisne }}
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
                    </div>
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

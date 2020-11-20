@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$hotel->oznaceni}}</h3>
                @if($address != null)
                    <p>{{$address->ulice}} {{$address->c_popisne}}, {{$address->mesto}}, {{$address->stat}}</p>
                @endif

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img class="card-img" src="/fetch_hotel_image/{{ $hotel->id }}"/>
                            </div>
                            <div class="col-8">
                                <p>{{$hotel->popis}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Availability
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <p>When would you like to stay at {{$hotel->oznaceni}}?</p>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

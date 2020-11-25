@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$hotel->oznaceni}}</h3>
                <p>{{$hotel->ulice}} {{$hotel->c_popisne}}, {{$hotel->mesto}}, {{$hotel->stat}}</p>
                {{--description--}}
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

                {{--room types--}}
                <div class="card mt-3">
                    <div class="card-header">
                        Available room types
                    </div>
                    <form method="POST" action="{{ route('hotels.public_show') }}">
                        @csrf

                        <ul class="list-group list-group-flush">
                            @foreach ($room_types as $index => $room_type)
                                @if( $room_type->total > 0)

                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-8">
                                            <div><b> {{ $room_type->name }} </b></div>
                                            <div> Bed count: {{ $room_type->beds_count }}</div>
                                            <div> Equipment: {{ $room_type->equipment}}</div>
                                        </div>

                                        <div class="cols-4">
                                            <div style="margin-bottom: 10px">
                                                <input name="room_types[{{ $room_type->id }}]" id="room_types"
                                                       type="number"
                                                       min="0" max="{{ $room_type->total }}"
                                                       value="{{$selected[0]}}" required>
                                            </div>
                                            <div>
                                                Price: {{ $room_type->price }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            @endforeach
                            <li>
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4 text-center">
                                        <button type="submit" style="width: 300px"
                                                class="btn btn-primary align-self-center">
                                            Order
                                        </button>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                            </li>

                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




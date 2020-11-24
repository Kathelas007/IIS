@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$hotel->oznaceni}}</h3>
               {{-- @if($address != null) --}}
                    <p>{{$hotel->ulice}} {{$hotel->c_popisne}}, {{$hotel->mesto}}, {{$hotel->stat}}</p>
               {{-- @endif --}}

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

                {{--room types --}}
                <div class="card mt-3">
                    <form method="POST" action="{{ route('hotels.public_show') }}">
                        @csrf

                        @foreach ($room_types as $room_type)
                            <div class="form-group row">
                                <label for="room_types" class="col-4 col-form-label text-right">{{ $room_type['type']->name }}</label>

                                <div class="col-6">
                                    <select name="room_types[{{ $room_type['type']->id }}]" id="room_types" class="form-control">
                                        @for ($i = 0; $i <= $room_type['count']; $i++)
                                            <option value="{{ $i }}"  @if($i == $room_type['selected']) selected @endif>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary">
                                Order
                            </button>
                        </div>
                    </form>
                </div>



                {{--    <ul class="pagination list-group list-group-flush">
                    @foreach ($room_type as $type)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-2">
                                        <img class="card-img" src="/fetch_room_type_image/{{ $type->image }}"/>
                                    </div>
                                    {<div class="col-8">
                                        <p>{{ $type->popis}}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        TODO jen fake data
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-3">
                                    <img class="card-img" src="/fetch_hotel_image/1"/>
                                </div>
                                <div class="col-8">
                                    <div class="card-text">
                                        popis + dalsi info
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>--}}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '3d'
        });
    </script>
@endsection



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

{{--                mozna to tu zustatne, zatim nemazat--}}
                {{--  datepicker--}}
{{--                <div class="card mt-3">--}}
{{--                    <div class="card-header">--}}
{{--                        Availability--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row-cols-1">--}}
{{--                            <div class="card-text">--}}
{{--                                <p>When would you like to stay at {{$hotel->oznaceni}}?</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <label>Check in:</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <label>Check out:</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <input class="datepicker form-control" type="text">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <input class="datepicker form-control" type="text">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <button type="submit" class="btn btn-secondary">--}}
{{--                                    Check--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                {{--room types --}}
                <div class="card mt-3">
                    <ul class="pagination list-group list-group-flush">
                        {{--                    @foreach ($room_type as $type)--}}
                        {{--                        <li class="list-group-item">--}}
                        {{--                            <div class="row">--}}
                        {{--                                <div class="col-2">--}}
                        {{--                                    <img class="card-img" src="/fetch_room_type_image/{{ $type->image }}"/>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-8">--}}
                        {{--                                    <p>{{ $type->popis}}</p>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                        {{--                    @endforeach--}}

                        {{-- TODO jen fake data--}}
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
                    </ul>
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



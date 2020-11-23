@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.search_bar')

            <div class="col-md-10">
                @if($hotels->total() == 0)
                    <p> Sorry, no results found for: {{request()->input('query')}} from {{request()->input('query_in')}} to {{request()->input('query_out')}}</p>
                @else
                    <div class="card">
                        @if($hotels->total() == 1)
                            <div class="card-header">{{$hotels->total()}} result found
                                for {{request()->input('query')}}</div>
                        @else
                            <div class="card-header">{{$hotels->total()}} results found
                                for {{request()->input('query')}}</div>
                        @endif

                        <ul class="pagination list-group list-group-flush">
                            @foreach ($hotels as $hotel)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-2 text-left">
                                            <img src="/fetch_hotel_image/{{ $hotel->id }}"/>
                                        </div>
                                        <div class="col-8 text-left align-content-center">
                                            <form method="GET" class="d-inline" action="{{ route('hotels.public_show') }}">
                                                <input type="hidden" name="hotel_id" value={{ $hotel->id }}>
                                                <input type="hidden" name="start_date" value={{ $start_date}}>
                                                <input type="hidden" name="end_date" value={{ $end_date }}>
                                                <button type="submit" class="btn btn-link align-baseline">
                                                    {{$hotel->oznaceni}}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                @endif
                <div class="flex-row pagination d-flex justify-content-center">
                    {{-- add search query to URL--}}
                    {!! $hotels->appends(['query' => request()->input('query')])->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

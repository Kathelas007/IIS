@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.search_bar')

            <div class="col-md-10">
                @if(count($hotel_results) == 0)
                    <p> Sorry, no results found for: {{request()->input('query')}}</p>
                @else
                    <div class="card">
                        @if(count($hotel_results) == 1)
                        <div class="card-header">{{count($hotel_results)}} result found
                            for {{request()->input('query')}}</div>
                        @else
                            <div class="card-header">{{count($hotel_results)}} results found
                                for {{request()->input('query')}}</div>
                        @endif

                        <ul class="list-group list-group-flush">
                            @foreach ($hotel_results as $hotel)
                                <li class="list-group-item">{{ $hotel->oznaceni }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

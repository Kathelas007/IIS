@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @include('components.search_bar')

        <div class="col-md-10">
            @if(count($hotel_results) == 0)
                <p> Sorry, no results found for: {{request()->input('query')}}</p>
            @else
                <h3> Search Results</h3>
                <p> {{count($hotel_results)}} results found for {{request()->input('query')}}</p>
                <div class="card">
                    @foreach ($hotel_results as $hotel)
                        <p>Hotel: {{ $hotel->oznaceni }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

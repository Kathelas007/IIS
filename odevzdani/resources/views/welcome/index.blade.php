@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('components.search_bar')

            <div class="col-md-10">
                <div class="card">
                    <p>Search for hotels and get the perfect room for you!</p>
                </div>
            </div>

        </div>
    </div>
@endsection

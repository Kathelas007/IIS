@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('components.search_bar')

            <div class="col-md-10">
                <div class="card">
                    <p>some page info</p>
                </div>
            </div>
        </div>
    </div>
@endsection

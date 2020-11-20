@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hotel Detail</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-8 text-left">
                           <h1>{{ $hotel->oznaceni}}</h1>
                    </div>
                    <div class="col-4 text-right">
                        <img src="/fetch_hotel_image/{{ $hotel->id }}"/>
                    </div>
                </div>
                <div class="row">
                    {{-- Vzdycky nazev polozky a hodnota na jednom radku --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

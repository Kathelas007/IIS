@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Hotel Detail</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-7 text-left">
                           <h1>{{ $hotel->oznaceni}}</h1>
                        </div>
                        <div class="col-4 text-right">
                            <img src="/fetch_hotel_image/{{ $hotel->id }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7 text-left">
                            <div class="row">
                                <div class="col">
                                    <h2>Description<h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{ $hotel->popis }}
                                </div>
                            </div>
                        </div>
                        <div class="col-5 text-right">
                            <div class="row">
                            <h2>Address</h2>
                            </div>
                            @if ($address != NULL)
                                <div class="row">
                                    <div class="col-5 text-left">
                                        Country:
                                    </div>
                                    <div class="col-6 text-left">
                                        {{ $address->stat }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-left">
                                        City:
                                    </div>
                                    <div class="col-6 text-left">
                                        {{ $address->mesto }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-left">
                                        Street, no.:
                                    </div>
                                    <div class="col-6 text-left">
                                        {{ $address->ulice }}, {{ $address->c_popisne }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-left">
                                        Postal code:
                                    </div>
                                    <div class="col-6 text-left">
                                        {{ $address->PSC }}
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    No address to display
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                            <a href="{{ route('hotels.edit', $hotel) }}">Edit hotel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

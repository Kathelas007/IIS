@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hotels list</div>

                <div class="card-body">
                    @foreach ($hotels as $hotel)
                    <div class="row">
                        <div class="col-4 text-left">
                            {{$hotel->oznaceni}}
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('hotels.owner_show', $hotel) }}">Detail</a>
                        </div>
                        <div class="col-3 text-right">
                            Delete option here
                            {{--<a href="{{ route('hotels.edit', $order) }}">Delete</a>--}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            Rooms
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('rooms.create', $hotel) }}">
                                <button class="btn btn-primary">
                                    Add Room
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($rooms as $room)
                     <div class="row mt-1">
                        <div class="col-4 text-left">
                            No.: {{ $room->number }}
                        </div>
                        <div class="col-4 text-center">
                            {{ $room->name }}
                        </div>
                        <div class="col text-right">
                        <form method="POST", action="{{ route('rooms.destroy',[ 'hotel' => $hotel, 'id' => $room->id]) }}">
                                @csrf
                                @method('DELETE')
                                <div class="form-group row mb-0">
                                   <div class="col text-right">
                                        <button class="btn btn-primary">
                                            Delete
                                       </button>
                                   </div>
                                </div>
                          </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

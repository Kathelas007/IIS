@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Edit Room</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rooms.edit', ['hotel' => $hotel, 'room' => $room]) }}">
                        @csrf

                        <input type="hidden" id="hotel_id" name="hotel_id" value="{{$hotel->id}}">
                        <div class="form-group row">
                            <label for="number" class="col-4 col-form-label text-right reqlabel">No.:</label>

                            <div class="col-6">
                                <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number', $room->number) }}" autofocus>

                                @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Type name</label>
                            <div class="col-md-6">
                                <select name="type_id" id="type_id" class="form-control">
                                    @foreach ($roomTypes as $roomType)
                                    @if($roomType->id == $room->roomType_id)
                                        <option value="{{ $roomType->id }}" selected>{{ $roomType->name }}</option>
                                    @else
                                        <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 text-right">
                                <button type="submit" class="btn btn-primary">
                                   Edit Room
                                </button>
                            </div>
                        </div>
                    </form>
                    @include('components.required_note')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

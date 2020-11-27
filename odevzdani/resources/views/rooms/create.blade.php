@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Add Room</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rooms.create', $hotel) }}">
                        @csrf

                        <input type="hidden" id="hotel_id" name="hotel_id" value="{{$hotel->id}}">
                        <div class="form-group row">
                            <label for="number" class="col-4 col-form-label text-right">No.:</label>

                            <div class="col-6">
                                <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number') }}" autofocus>

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
                                    <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 text-right">
                                <button type="submit" class="btn btn-primary">
                                    Add Room
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Edit Room Type</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('roomTypes.edit', ['hotel' => $hotel, 'roomType' => $roomType]) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label text-right reqlabel">Type name</label>

                            <div class="col-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $roomType->name)  }}" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="beds_count" class="col-4 col-form-label text-right reqlabel">Number of beds</label>

                            <div class="col-6">
                                <input id="beds_count" type="text" class="form-control @error('beds_count') is-invalid @enderror" name="beds_count" value="{{ old('beds_count', $roomType->beds_count) }}" autofocus>

                                @error('beds_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-4 col-form-label text-right reqlabel">Price</label>

                            <div class="col-6">
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $roomType->price) }}" autofocus>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="equipment" class="col-4 col-form-label text-right">Equipment</label>

                            <div class="col-6">
                                <textarea id="equipment" type="text" class="form-control @error('equipment') is-invalid @enderror" name="equipment">{{ old('equipment', $roomType->equipment) }}</textarea>

                                @error('equipment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 text-right">
                                <button type="submit" class="btn btn-primary">
                                    Edit Type
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

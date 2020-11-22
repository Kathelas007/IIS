@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Add Hotel</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hotels.add') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="oznaceni" class="col-4 col-form-label text-right">Hotel name</label>

                            <div class="col-6">
                                <input id="oznaceni" type="text" class="form-control @error('oznaceni') is-invalid @enderror" name="oznaceni" value="{{ old('oznaceni') }}" autofocus>

                                @error('oznaceni')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stat" class="col-4 col-form-label text-right">Country</label>

                            <div class="col-6">
                                <input id="stat" type="text" class="form-control @error('stat') is-invalid @enderror" name="stat" value="{{ old('stat') }}" autofocus>

                                @error('stat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mesto" class="col-4 col-form-label text-right">City</label>

                            <div class="col-6">
                                <input id="mesto" type="text" class="form-control @error('mesto') is-invalid @enderror" name="mesto" value="{{ old('mesto') }}" autofocus>

                                @error('mesto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ulice" class="col-4 col-form-label text-right">Street</label>

                            <div class="col-6">
                                <input id="ulice" type="text" class="form-control @error('ulice') is-invalid @enderror" name="ulice" value="{{ old('ulice') }}" autofocus>

                                @error('ulice')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-4 col-form-label text-right">No.</label>

                            <div class="col-6">
                                <input id="c_popisne" type="text" class="form-control @error('c_popisne') is-invalid @enderror" name="c_popisne" value="{{ old('c_popisne') }}">

                                @error('c_popisne')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="PSC" class="col-4 col-form-label text-right">Postal Code</label>

                            <div class="col-6">
                                <input id="PSC" type="text" class="form-control @error('PSC') is-invalid @enderror" name="PSC" value="{{ old('PSC') }}">

                                @error('PSC')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="popis" class="col-4 col-form-label text-right">Description</label>

                            <div class="col-6">
                                <textarea id="popis" type="text" class="form-control @error('popis') is-invalid @enderror" name="popis">{{ old('popis') }}</textarea>

                                @error('popis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 text-right">
                                <button type="submit" class="btn btn-primary">
                                    Add Hotel
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

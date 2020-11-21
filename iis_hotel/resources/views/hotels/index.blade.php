@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            Your hotels
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('hotels.add') }}">Add hotel</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($hotels as $hotel)
                    <div class="row">
                        <div class="col-4 text-left">
                            {{$hotel->oznaceni}}
                        </div>
                        <div class="col-4 text-right">
                                <a href="{{ route('hotels.owner_show', $hotel) }}">
                                    <button class="btn btn-primary">
                                        Detail
                                     </button>
                                </a>
                        </div>
                        <div class="col-3 text-right">
                        <form method="POST", action="/hotels/{{ $hotel->id }}">
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

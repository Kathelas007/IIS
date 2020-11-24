@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col text-left">
                        Assign receptionists to {{ $hotel->oznaceni }}
                    </div>
                    <div class="col text-right">
                        <button type="submit" class="btn btn-primary" form="assignClerks">
                            Assign
                        </button>
                    </div>
                </div>
             </div>

                <div class="card-body">
                    <form id="assignClerks" method="POST" action="{{ route('hotels.clerk_choose', $hotel) }}">
                        @csrf

                        @foreach ($clerks as $clerk)
                        <div class="row">
                            <div class="col-4 text-left">
                                {{ $clerk->lastname }} {{ $clerk->firstname }}
                            </div>

                            <div class="col-4 text-left">
                                {{$clerk->email}}
                            </div>

                            <div class="col-3 text-right">
                            <input type="checkbox" id="{{ $clerk->id }}" name="clerks[]" value="{{ $clerk->id }}">
                            </div>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Edit Hotel</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hotels.edit') }}">
                        @csrf
                    </form>
                    How editty!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

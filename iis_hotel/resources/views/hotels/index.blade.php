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
                        <div class="col-4 text-right">
                            {{$hotel->oznaceni}}
                        </div>
                        <div class="col-4">
                            Tady bude odkaz na zobrazit
                        </div>
                    </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

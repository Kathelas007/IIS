@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profiles list</div>

                <div class="card-body">
                    @foreach ($users as $user)
                        <div class="row">
                            <div class="col-4 text-right">
                                {{ $user->firstname.' '.$user->lastname }}
                            </div>
                            <div class="col-4">
                                {{ $user->email }}
                            </div>
                            @if(Auth::user()->id != $user->id)
                                <div class="col-4">
                                    <a href="{{ route('profile.show', $user->id) }}">
                                        Edit
                                    </a>
                                    <form method="POST" class="d-inline" action="{{ route('profile.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-3"></div>
                        <a href="{{ route('register') }}" class="col-9">Register new user</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

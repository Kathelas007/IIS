@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as <span class="text-lowercase">{{ Auth::user()->roleString() }}</span>

                    @authAtLeast(Auth::user()::role_admin)
                        @foreach ($users as $user)
                            <div class="row">
                                <div class="col-4 text-right">
                                    User:
                                </div>
                                <div class="col-4">
                                    {{ $user->name }}
                                </div>
                                @if(Auth::user()->id != $user->id)
                                    <div class="col-4">
                                        <a href="{{ route('profile.index', $user->id) }}">
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
                    @endauthAtLeast
                    @authAtLeast(Auth::user()::role_clerk)
                        <div class="row">
                            <div class="col-3"></div>
                            <a href="{{ route('orders.index') }}" class="col-9">Manage orders</a>
                        </div>
                    @endauthAtLeast
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

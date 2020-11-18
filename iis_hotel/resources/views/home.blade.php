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
                    <div class="row">
                        <div class="col-3"></div>
                        <a href="{{ route('profile.index') }}" class="col-9">Manage users</a>
                    </div>
                    @endauthAtLeast You are logged in as Customer
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

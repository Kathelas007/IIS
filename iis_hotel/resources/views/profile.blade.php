@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-right" >
                            Name:
                        </div>
                        <div class="col-4">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="col-4">
                            <a href="{{ route('profile.name') }}">Change</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            E-mail:
                        </div>
                        <div class="col-8">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                    @authAtLeast(Auth::user()::role_clerk)
                        <div class="row">
                            <div class="col-4 text-right">
                                Role:
                            </div>
                            <div class="col-8">
                                {{ Auth::user()->roleString() }}
                            </div>
                        </div>
                    @endauthAtLeast
                    <div class="row">
                        <div class="col-4">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9">
                            <a href="{{ route('profile.password') }}">Change password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

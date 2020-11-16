@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-right" >
                            Name:
                        </div>
                        <div class="col-4">
                            {{ $user->name }}
                        </div>
                        <div class="col-4">
                            <a href="{{ route('profile.edit.name', $user->id) }}">Change</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            E-mail:
                        </div>
                        <div class="col-8">
                            {{ $user->email }}
                        </div>
                    </div>
                    @authAtLeast(Auth::user()::role_clerk)
                        <div class="row">
                            <div class="col-4 text-right">
                                Role:
                            </div>
                            <div class="col-4">
                                {{ $user->roleString() }}
                            </div>
                            @authAtLeast(Auth::user()::role_admin)
                                @if ($user->role != Auth::user()::role_admin)
                                    <div class="col-4">
                                        <a href="{{ route('profile.edit.role', $user->id) }}">Change</a>
                                    </div>
                                @endif
                            @endauthAtLeast
                        </div>
                    @endauthAtLeast
                    <div class="row">
                        <div class="col-4">

                        </div>
                    </div>
                    @if(Auth::user()->id == $user->id)
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <a href="{{ route('profile.edit.password') }}">Change password</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

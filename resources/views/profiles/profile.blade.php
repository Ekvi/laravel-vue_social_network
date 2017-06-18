@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">
                        {{$user->name}}'s profile
                    </p>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <img src="{{Storage::url($user->avatar)}}" width="140px" height="140px">
                    </div>

                    <p class="text-center">
                        @if(!empty($user->profile))
                            {{$user->profile->location}}
                        @endif
                    </p>

                    <p class="text-center">
                        @if(Auth::id() == $user->id)
                            <a href="{{route('profile.edit')}}" class="btn btn-lg btn-info">Edit your profile</a>
                        @endif
                    </p>
                </div>
            </div>

            @if(Auth::id() !== $user->id)
                <div class="panel pane-default">
                    <div class="body">
                        <friend :profile-user-id="{{$user->id}}"></friend>
                    </div>
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">
                        About me
                    </p>
                </div>
                <div class="panel-body">
                    <p class="text-center">
                        @if(!empty($user->profile))
                            {{$user->profile->about}}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop

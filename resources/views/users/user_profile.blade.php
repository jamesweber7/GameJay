@extends('layouts.app')
@section('content')
    <div class="flex justify-center">
        <div class="m-12 rounded-lg p-12" style="background-color:#242424;color:#ffffff;width:60%;">
            WELCOME TO {{$user->username}}'s PROFILE
            <br />
            <br />
            <div class="profile-picture-lg profile-picture-lg-auth" onhover="showIcon">
                {{$user->image()}}
                {{-- <x-eos-edit id='edit-icon' class="hidden pic-edit-icon"/> --}}
            </div>
            <br />
            <br />
            Games By {{$user->username}}:
            @foreach ($games as $game)
                <div style="padding:20px;width:100%;">
                    <x-game_card :game="$game" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
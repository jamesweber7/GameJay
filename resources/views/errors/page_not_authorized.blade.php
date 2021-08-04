@extends('layouts.error_card')

@section('error_content')
    Uh Oh! You don't have permission to edit <i>{{$game->name}}</i>!
    <br/>
    <br/>
    <a href="{{route('game', [$game->user()->username, $game->name ])}}" class="redirect-button-1">{{ "Play $game->name" }}</a>
    <a href="{{ route('dashboard') }}" class="redirect-button-1">Dashboard</a>
    @guest
        <a href="{{ route('login') }}" class="redirect-button-1">Log in</a>
    @endguest
    <a href="{{ route('report_issue') }}" class="redirect-button-1">Report Issue</a>
@endsection
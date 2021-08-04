@extends('layouts.error_card')

@section('error_content')
    @if(Auth::check() && $game->user()->id===auth()->user()->id)
        Uh Oh! We couldn't find <i>{{$game->name}}</i>'s index.html file!<br>
        Please reupload a zip file which contains a file named index.html
        <br/>
        <br/>
        <a href="{{ route('edit_game', [$game->user()->username, $game->name]) }}" class="redirect-button-1">{{ "Edit $game->name" }}</a>
        <a href="{{ route('dashboard') }}" class="redirect-button-1">Dashboard</a>
        <a href="{{ route('report_issue') }}" class="redirect-button-1">Report Issue</a>
    @else
        Shoot! <i>{{$game->name}}</i> is facing some upload difficulties! <br>
        Please try again later!
        <br/>
        <br/>
        <a href="{{ route('user', $game->user()->username) }}" class="redirect-button-1">{{ $game->user()->username . "'s profile" }}</a>
        <a href="{{ route('dashboard') }}" class="redirect-button-1">Dashboard</a>
        @guest
            <a href="{{ route('login') }}" class="redirect-button-1">Log in</a>
        @endguest
    @endif
@endsection
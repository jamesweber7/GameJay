<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if (Route::currentRouteName()==='game')
        <link rel="icon" href={{asset($game->cover_picture())}}>
        <title>{{Route::current()->name}}</title>
    @elseif (Route::currentRouteName()==='user')
        <link rel="icon" href={{asset($user->profile_picture())}}>
        <title>{{Route::current()->username}}</title>
    @else
        <link rel="icon" href={{asset("favicon2.ico")}}>
        @if (Route::currentRouteName()==='search')
            <title>'{{urldecode(str_replace(url()->current().'?qry=', '', url()->full()))}}' Search Results</title>
        @elseif (Route::currentRouteName()==='about')
            <title>About GameJay</title>
        @elseif (Route::currentRouteName()==='home')
            <title>GameJay</title>
        @else
            <title>{{ucwords(str_replace('_', ' ', Route::currentRouteName()))}}</title>
        @endif
    @endif

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color:#1A1A1F;" class="app-body">
    <nav class="p-6 bg-white flex justify-between mb-6 text-xl" style="background-color: rgb(162, 221, 255)">
        <ul class="flex items-center">
            <li>
                <a href="{{ route('home') }}" class="p-3">Home</a>
            </li>
            <li>
                <a href="{{ route('about') }}" class="p-3">About</a>
            </li>
        </ul>

        <form id="searchbar" action="{{ route('search') }}" enctype="multipart/form-data" method="get" class="nice-input-2 neon-border-1" style="padding:0;font-size:20px;width:100%">
            <label for="qry" class="sr-only"></label>
            <input type="text" id="qry" name="qry" class="invisible-input jay-input-colors search-bar" placeholder="Search by game, author, tag, ...." originalplaceholder='Search by game, author, tag, ....' onfocus="this.placeholder=''" onblur="this.placeholder=this.getAttribute('originalplaceholder')" value={{ old('qry') }}>
            <button type="submit" style="float:right;color:var(--jay-blue);width:30px;padding:5px;margin-top:5px;">
                <x-go-search-24 />
            </button>
        </form>

        <ul class="flex items-center">
 
            @auth
            <li>
                <a href="{{ route('user', auth()->user()->username) }}" class="p-3">{{ auth()->user()->name }}</a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="post" class="p-3 inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
            @endauth

            @guest
            <li>
                <a href="{{ route('login') }}" class="p-3">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="p-3">Register</a>
            </li>
            @endguest

            <li>
                <a href="{{ route('upload_game') }}" class="p-3">Upload</a>
            </li>
            
        </ul>
    </nav>

    <div class="body-div">
        @yield('content')
    </div>
    
</body>
</html>
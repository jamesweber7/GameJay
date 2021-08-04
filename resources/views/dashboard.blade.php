@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12" style="font-family:Verdana;background-color:var(--div-dark);color:var(--jay-blue);border-radius:10px;">
            <div style="margin:40px;font-size:30px;font-family:Arial Black;font-weight:bold;">
                Check Out Our Most Popular Games!
            </div>
            @foreach ($games as $game)
                <div style="padding:20px;width:100%;">
                    <x-game_card :game="$game" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
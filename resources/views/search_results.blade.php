@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12" style="font-family:Verdana;background-color:var(--div-dark);color:var(--jay-blue);border-radius:10px;">

            @if (count($games) || $user)
                
            <div style="padding:32px;font-size:26px;">
                Search results for <i>{{urldecode(str_replace(url()->current().'?qry=', '', url()->full()))}}</i>
            </div>
                
                @if ($user)
                    <div style="padding:24px;padding-bottom:0;font-size:23px;color:var(--jay-deep-blue-gray)">
                        User
                    </div>
                    <div style="padding:20px;width:100%;">
                        <x-user_card :user="$user" />
                    </div>
                @endif

                @if (count($games))
                    <div style="padding:24px;font-size:23px;color:var(--jay-deep-blue-gray)">
                        Returned {{ count($games) }} {{ Str::plural('Game', count($games)) }}
                    </div>
                    @foreach ($games as $game)
                        <div style="padding:20px;width:100%;">
                            <x-game_card :game="$game" />
                        </div>
                    @endforeach
                @endif
            @else

                <div style="padding:20px;width:100%;aspect-ratio:2/1;display:block;justify-content:center;">
                    <div style="display:block;position:relative;top:50%;text-align:center;width:100%;">
                        Shoot! It looks like <i>'{{str_replace(url()->current().'?qry=', '', url()->full())}}'</i> didn't match any results!
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

<a href="{{ route('game', [$game->user()->username, $game->name]) }}">
    <div class="game-card-1" style="overflow:hidden;">
        <div class="left-column" style="width:66%;height:100%;margin:0;padding:0;display:inline-block;">
            <div style="display:inline-block;">
                <img src="{{asset($game->cover_picture())}}" style="align:center;" alt=''>
            </div>
        </div>
        
        <div class="right-column" style="width:33%;height:100%;margin:0;padding:2%;display:inline-block;vertical-align:top;">
            <div style="color:var(--jay-blue-deeper);font-size:24px">
                {{ $game->name }}
            </div>
            <div style="display:inline-block;">
                <div class="profile-picture-sm" style="width:25%;">
                    {{ $game->user()->image() }}
                </div>
                <div style="color:var(--jay-blue-deeper);display:inline-block;font-size:20px;position:relative;bottom:14px;">
                    {{ $game->user()->username }}
                </div>
            </div>
            <br>
            <div style="word-break:break-word;">
                {{ $game->simple_description }}       
            </div>
        </div>
    </div>
</a>

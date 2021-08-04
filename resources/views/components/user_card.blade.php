
<a href="{{ route('user', $user->username) }}">
    <div class="user-card-1" style="overflow:hidden;">
        <div class="left-column" style="width:33%;height:100%;margin:0;padding:0;display:inline-block;padding:14px;">
            <div class="profile-picture-lg" style="display:inline-block;width:160px;height:160px;">
                {{$user->image()}}
            </div>
            <div style="color:var(--jay-blue-deeper);font-size:44px">
                {{ $user->username }}
            </div>
            <div style="color:var(--jay-deep-blue-gray);font-size:24px">
                User since {{ $user->created_at->diffForHumans() }}
            </div>
        </div>
        
        <div class="right-column" style="width:66%;height:100%;margin:0;padding:2%;display:inline-block;vertical-align:top;">
            <?php
                use App\Models\Game;
                $games = Game::where('user_id', $user->id)->take(3)->get();
                if (count($games)) {
                    $gameCount = Game::where('user_id', $user->id)->count();
                    echo "<div style='font-size:26px;color:var(--jay-blue-deeper)'>".$gameCount." Games </div><br>";
                    foreach ($games as $game) {
                        echo "
                            <div style='width:30%;aspect-ratio:4/3;display:inline-block;overflow:hidden;'>
                                {$game->name}
                                <img src='{$game->cover_picture()}' alt='image'>
                            </div>
                        ";
                    }
                }
            ?>
            <br>
            BIO WILL GO HERE
        </div>
    </div>
</a>

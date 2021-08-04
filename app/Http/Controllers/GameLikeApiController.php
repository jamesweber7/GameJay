<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;
use App\Models\Game;
use App\Models\Like;
use App\Models\User;

class GameLikeApiController extends Controller
{

    public function index()
    {
        return Like::all();
    }

    public function indexForGame(Game $game)
    {
        return Like::where('game_id', $game->id);
    }

    public function store(Game $game, $user_id)
    {
        if (!$game->likedById($user_id)) {
            Like::create([
                'user_id' => $user_id,
                'game_id' => $game->id,
            ]);
        }
    }

    public function destroy(Game $game, $user_id)
    {
        Like::where('user_id', $user_id)->where('game_id', $game->id)->delete();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{

    public function index(String $author_username, String $name) {

        $author = User::where('username', $author_username)->first();
        $author_id = $author->id;
        
        $game = Game::where('user_id', $author_id)->where('name', $name)->first();

        if (!$game->source) {
            return redirect(route('index_not_found', [$author_username, $name]));
        }
        
        return view('components.game', [
            'game' => $game
        ]);
    }

    public function serve(String $game_id) {
        $game = Game::find($game_id);
        return view('components.serve_game', [
            'game' => $game
        ]);
        
    }
}

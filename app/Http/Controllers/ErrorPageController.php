<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

class ErrorPageController extends Controller
{
    public function index_not_found(String $author_username, String $name) {

        $game = $this->retreiveGame($author_username, $name);
        
        return view('errors.index_not_found', [
            'game' => $game
        ]);
    }

    public function game_error(String $author_username, String $name) {

        $game = $this->retreiveGame($author_username, $name);

        return view('errors.game_error', [
            'game' => $game
        ]);
    }

    public function unauthorized(String $author_username, String $name) {

        $game = $this->retreiveGame($author_username, $name);

        return view('errors.page_not_authorized', [
            'game' => $game
        ]);
    }

    private function retreiveGame(String $author_username, String $name) {
        $author = User::where('username', $author_username)->first();
        $author_id = $author->id;
        
        $game = Game::where('user_id', $author_id)->where('name', $name)->first();

        return $game;
    }

}

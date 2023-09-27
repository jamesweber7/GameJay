<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Like;

class HomeController extends Controller
{

    public function index() {

        $games = Game::paginate(10)->sortByDesc(function ($game) {
            return $game->likes()->count();
        });

        return view('dashboard', [
            'games' => $games
        ]);
    }
}

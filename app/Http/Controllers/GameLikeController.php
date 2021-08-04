<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;


class GameLikeController extends Controller
{
    public function store(Game $game, Request $request) {
        
        if ($game->likedBy($request->user())) {
            return;
        }

        $game->likes()->create([
            'user_id' => $request->user()->id,
        ]);
    }
}

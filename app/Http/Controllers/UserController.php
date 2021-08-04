<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;

class UserController extends Controller
{
    public function index(String $username) {

        $user = User::where('username', $username)->first();

        $user_id = $user->id;
        $games = Game::where('user_id', $user_id)->paginate(10);

        return view('users.user_profile', [
            'user' => $user,
            'games' => $games
        ]);
    }
}

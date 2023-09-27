<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'body',
    ];

    public function user() {
        $user_id = $this->user_id;
        return User::find($user_id);
    }

    public function game() {
        $game_id = $this->game_id;
        return Game::find($game_id);
    }
    
}

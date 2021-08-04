<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;
use App\Models\Game;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;

class GameCommentApiController extends Controller
{

    public function index()
    {
        return Comment::all();
    }

    public function store(Game $game, $user_id, $comment_body)
    {
        Comment::create([
                'user_id' => $user_id,
                'game_id' => $game->id,
                'body' => $comment_body,
            ]);
    }

    public function destroy($comment_id)
    {
        Comment::where('id', $comment_id)->delete();
    }
}

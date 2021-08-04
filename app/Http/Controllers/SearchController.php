<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    public function search(Request $request) {

        $qry = $request->qry;

        if (!$this->isUsernameSearch($qry)) {
            $games = $this->gameFind($qry);
        } else {
            $games = [];
        }

        if (!$this->isTagSearch($qry)) {
            $user = $this->userFind($qry);
        } else {
            $user = null;
        }

        return view('search_results', [
            'games' => $games,
            'user' => $user
        ]);
    }

    public function gameFind($qry) {
        $qry = str_replace('#', ' ', $qry);
        $qry = str_replace('%23', ' ', $qry);
        $tags = explode(' ', $qry);
        $games = Game::where('name', 'like', $qry)
            ->orWhere(function($query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->orWhereJsonContains('tags', $tag);
                }
                return $query;
            })
            ->paginate(10)
            ->sortByDesc(function ($game) {
                return $game->likes()->count();
            });
        return $games;
    }

    public function userFind($qry) {
        $qry = str_replace('@', '', $qry);
        $qry = str_replace('%40', '', $qry);
        if (!str_contains($qry, ' ')) {
            $user = User::where('username', 'like', $qry)->first();
        } else {
            $user = null;
        }
        return $user;
    }

    public function isUsernameSearch($qry) {
        return substr($qry, 0, 1) === '@' || substr($qry, 0, 3) === '%40';
    }

    public function isTagSearch($qry) {
        return substr($qry, 0, 1) === '#' || substr($qry, 0, 3) === '%23';
    }

}

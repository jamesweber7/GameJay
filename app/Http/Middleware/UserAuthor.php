<?php

namespace App\Http\Middleware;

use App\Models\Game;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;

class UserAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $author_username = $request->route()->parameter('author_username');
        $author = User::where('username', $author_username)->first();
        $author_id = $author->id;
        if (!Auth::check() || Auth::user()->id !== $author_id) {
            $name = $request->route()->parameter('name');
            return redirect(route('unauthorized', [$author_username, $name]));
        }
        return $next($request);
    }
}

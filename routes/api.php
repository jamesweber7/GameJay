<?php

use App\Http\Controllers\GameLikeApiController;
use App\Http\Controllers\GameCommentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\Like;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/likes', [GameLikeApiController::class, 'index'])->name('game.likes');
Route::post('/likes/{game:id}/{user_id}', [GameLikeApiController::class, 'store'])->name('game.likes');
Route::delete('/likes/{game:id}/{user_id}', [GameLikeApiController::class, 'destroy'])->name('game.likes');

Route::get('/comments', [GameCommentApiController::class, 'index'])->name('game.comments');
Route::post('/comments/{game:id}/{user_id}/{comment_body}', [GameCommentApiController::class, 'store'])->name('game.post-comment');
Route::put('/comments/{game:id}/{user_id}/{comment_body}', [GameCommentApiController::class, 'update'])->name('game.update-comment');
Route::delete('/comments/{comment_id}', [GameCommentApiController::class, 'destroy'])->name('game.destroy-comment');
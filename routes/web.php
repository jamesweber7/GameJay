<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\EditGameController;
use App\Http\Controllers\ErrorPageController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameLikeController;
use App\Http\Controllers\GameStatsController;
use App\Http\Controllers\GameStudioController;
use App\Http\Controllers\HelperPageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadGameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZipController;
use Illuminate\Support\Facades\Route;
use Illuminate\Translation\FileLoader;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;


// home
Route::any('/', [HomeController::class, 'index'])->name('home');

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// user profile
Route::get('/user/{username}', [UserController::class, 'index'])->name('user');

// search results
Route::get('/search', [SearchController::class, 'search'])->name('search');

// game
Route::get('/game/{author_username}/{name}', [GameController::class, 'index'])->name('game');

// upload game
Route::get('/upload-game', [UploadGameController::class, 'index'])->name('upload_game');
Route::post('/upload-game', [UploadGameController::class, 'store']);

// studio
Route::get('/studio', [GameStudioController::class, 'index'])->name('studio');

// edit game
Route::get('/edit/{author_username}/{name}', [EditGameController::class, 'index'])->name('edit_game');
Route::post('/edit/{author_username}/{name}', [EditGameController::class, 'store']);
Route::post('/delete/{author_username}/{name}', [EditGameController::class, 'delete'])->name('delete_game');

// stats
Route::get('/stats/{author_username}/{name}', [GameStatsController::class, 'index'])->name('game_stats');

// errors
Route::get('/unauthorized/{author_username}/{name}', [ErrorPageController::class, 'unauthorized'])->name('unauthorized');
Route::get('/game-error/{author_username}/{name}', [ErrorPageController::class, 'game_error'])->name('game_error');
Route::get('/index-not-found/{author_username}/{name}', [ErrorPageController::class, 'index_not_found'])->name('index_not_found');

// authentication
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// general
Route::get('/contact-us', [ContactFormController::class, 'contact'])->name('contact_us');
Route::get('/report-issue', [ContactFormController::class, 'report'])->name('report_issue');
// Route::get('/about', [HelperPageController::class, 'about'])->name('about');
Route::view('/about', 'about')->name('about');
Route::get('/help', [HelperPageController::class, 'help'])->name('help');
Route::get('/coming-soon', [HelperPageController::class, 'comingSoon'])->name('coming_soon');
Route::get('/coming-soon/{page}', [HelperPageController::class, 'comingSoon'])->name('coming_soon');

// zip file
Route::get('/zip', [ZipController::class, 'zipFile'])->name('zip');


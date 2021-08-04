<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
// use Dotenv\Exception\ValidationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use VIPSoft\Unzip\Unzip;
// use Illuminate\Http\File;
use File;
use Illuminate\Support\Facades\Storage;
use App\Rules\Uniquename;
use App\Rules\Containsindex;
use App\Models\User;
use ZipArchive;
use App\Http\Controllers\ZipController;
use Symfony\Component\Routing\Annotation\Route;
// use App;
// use Storage;

class EditGameController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(["user.author"]);
    }

    public function index(String $author_username, String $name) {
        
        $game = $this->getGame($author_username, $name);

        return view('components.edit_game', [
            'game' => $game
        ]);
    }

    public function store(Request $request, $author_username, $name)
    {

        $game = $this->getGame($author_username, $name);

        // find validations to make on the saved changes
        $validations = [];

        // check new game zip
        if ($request->game) {
            $validations['game'] = 'required|file|mimes:zip|max:10000000';
        }

        if ($request->name !== $game->name) {
            $validations['name'] = ['required', 'max:60', new Uniquename];
        }

        if ($request->simple_description !== $game->simple_description) {
            $validations['simple_description'] = 'required|max:150';
        }

        if ($request->detailed_description !== $game->detailed_description) {
            $validations['detailed_description'] = 'required';
        }

        if ($request->width !== strval($game->width)) {
            $validations['width'] = 'required|integer|max:4096';
        }

        if ($request->height !== strval($game->height)) {
            $validations['height'] = 'required|integer|max:4096';
        }

        // validate changes
        $this->validate($request, $validations);

        // make changes
        if ($request->name !== $game->name) {
            $game->name = $request->name;
        }

        if ($request->simple_description !== $game->simple_description) {
            $game->simple_description = $request->simple_description;
        }

        if ($request->detailed_description !== $game->detailed_description) {
            $game->detailed_description = $request->detailed_description;
        }

        if ($request->width !== strval($game->width)) {
            $game->width = $request->width;
        }

        if ($request->height !== strval($game->height)) {
            $game->height = $request->height;
        }

        if (($game->fullscreen===1) !== ($request->fullscreen==="on")) {
            $game->fullscreen = ($request->fullscreen==="on");
        }

        if ($request->game) {
            $spacelessGameName = str_replace(' ', '_', $request->name);
            // unique game folder name
            $uniqueGameName = $spacelessGameName . uniqid();

            // unique game file path
            $path = 'app/public/games/' . $uniqueGameName;

            // create game's folder
            app()->make('path.storage').(DIRECTORY_SEPARATOR.$path);

            // instantiate unzipper
            $unzipper  = new Unzip();

            // unzip game and store in folder
            $filenames = $unzipper->extract($request->game, storage_path($path)); //store folder in storage/app/public/games

            $source = '';
            // search for index file
            foreach ($filenames as $filename) {
                if (str_contains($filename, 'index.html')) {
                    $filename=str_replace(' ', '%20', $filename);
                    $source="storage/games/$uniqueGameName/$filename";
                }
            }

            if (!$source) {
                $this->deleteGameDirectory("storage/games/$uniqueGameName");
            }

            // save file source
            $game->source = $source;
        }

        $game->save();

        // redirect
        return redirect()->route('game', [$request->user()->username, $request->name]);
    }

    public function delete(String $author_username, String $name) {

        $game = $this->getGame($author_username, $name);

        if ($game->source) {
            $this->deleteGameDirectory($game->source);
        }

        Game::destroy($game->id);

        return redirect()->route('user', $author_username);
    }

    private function getGame(String $author_username, String $name) {
        $author = User::where('username', $author_username)->first();
        $author_id = $author->id;
        
        return Game::where('user_id', $author_id)->where('name', $name)->first();
    }

    private function deleteGameDirectory(String $gameSource) {
        $source = str_replace('storage', 'public', $gameSource);
        $indexOfUniqGameName = strlen('storage/games/');
        $lengthOfDirectory = strpos($source, '/', ($indexOfUniqGameName + 1));
        $source = substr($source, 0, ($lengthOfDirectory));
        Storage::deleteDirectory($source);
    }

}

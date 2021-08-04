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
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Rules\Uniquename;
use App\Rules\Workingyoutubelink;
use App\Models\User;
use ZipArchive;
use App\Http\Controllers\ZipController;

class UploadGameController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth']);
    }
 
    public function index()
    {
        return view('components.upload_game');
    }

    public function store(Request $request)
    {

        // validate
        $this->validate($request, [
            'name' => ['required', 'max:60', new Uniquename],
            'simple_description' => 'required|max:150',
            'game' => 'required|file|mimes:zip|max:10000000',
            'width' => 'required|integer|max:4096',
            'height' => 'required|integer|max:4096',
        ]);

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

        $GAME_IMAGE_FOLDER = 'gamejayimages';

        // create game's image folder
        // app()->make('path.storage').(DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$GAME_IMAGE_FOLDER);

        // set images array
        $images = [];


        // set image path
        $IMAGE_PATH = public_path("storage/games/$uniqueGameName/$GAME_IMAGE_FOLDER/");

        /*
        * Trying to make folder
        */
        $IMAGE_PATH_A = "public/games/$uniqueGameName/$GAME_IMAGE_FOLDER/";
        // app()->make('path.storage').(DIRECTORY_SEPARATOR.$IMAGE_PATH_A);
        Storage::makeDirectory($IMAGE_PATH_A);

        // find selected image
        $selected_image_number = str_replace('input_image_', '', $request->selected_image);

        $MAX_FILES = 5;

        // set selected image as first element of array if it exists
        $fileId = "input_image_$selected_image_number";
        if ($request->hasFile($fileId)) {

            // store file
            $stored_file = Storage::putFile($IMAGE_PATH_A, $request->file($fileId));
            $file_asset_path = str_replace('public', 'storage', $stored_file);
            array_push($images, $file_asset_path);


        }
        // add other images to array
        for ($i = 1; $i <= $MAX_FILES; $i++) {
            if ($i ===  intval($selected_image_number)) {
                $i++;
                if ($i > $MAX_FILES) {
                    return;
                }
            }

            $fileId = "input_image_$i";
            if ($request->hasFile($fileId)) {

                $stored_file = Storage::putFile($IMAGE_PATH_A, $request->file($fileId));
                $file_asset_path = str_replace('public', 'storage', $stored_file);
                array_push($images, $file_asset_path);

            }
        }


        // store data in database
        Game::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
            'source' => $source,
            'width' => $request->width,
            'height' => $request->height,
            'simple_description' => $request->simple_description,
            'detailed_description' => $request->detailed_description,
            'fullscreen' => $request->fullscreen==="on",
            'public' => $request->public==="on",
            'tags' => explode(',', $request->cool_tag_container),
            'images' => $images,
            'youtube_link' => $request->youtube_link,
        ]);
        
        // redirect
        return redirect()->route('game', [$request->user()->username, $request->name]);
    }

    private function deleteGameDirectory(String $gameSource) {
        $source = str_replace('storage', 'public', $gameSource);
        $indexOfUniqGameName = strlen('storage/games/');
        $lengthOfDirectory = strpos($source, '/', ($indexOfUniqGameName + 1));
        $source = substr($source, 0, ($lengthOfDirectory));
        Storage::deleteDirectory($source);
    }

    function println($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

}

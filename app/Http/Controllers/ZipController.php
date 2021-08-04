<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use File;

class ZipController extends Controller
{
    public function zipFile() {
        $zip = new ZipArchive;

        $zippedfile = 'zipfile.zip';
        $foldertobezipped = public_path('storage/games/No_Index_Game60f6606d56a94');
        if ($zip->open(public_path($zippedfile), ZipArchive::CREATE) === TRUE) {
            $files = File::files($foldertobezipped);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value,$relativeNameInZipFile);
            }
            $zip->close();
        }
        return $zip;
        // return response();
    }
}

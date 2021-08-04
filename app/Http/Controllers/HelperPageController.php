<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperPageController extends Controller
{
    public function about() {
        return $this->comingSoon();
    }

    public function help() {
        return $this->comingSoon();
    }

    public function comingSoon() {
        return view('coming_soon');
    }

}

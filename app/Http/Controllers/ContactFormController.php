<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function contact() {
        return view('contact');
    }

    public function report() {
        return view('report');
    }
}

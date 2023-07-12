<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageTranslationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$sel_lang = request()->cookie('sel_lang');
        return view("back.language");
    }
}

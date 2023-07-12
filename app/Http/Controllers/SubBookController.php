<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Facades\Util;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubBookController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view("back.book.sub_book.index");
    }

   
}

<?php

namespace App\Http\Controllers;


use App\Facades\Common;
use App\Facades\Util;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsFeedController extends Controller
{
    
    public function index(){
   
    return view('back.newsfeed');
       
    }
}

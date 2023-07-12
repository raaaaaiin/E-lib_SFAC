<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimelineController extends Controller
{
     public function index(){
   
    return view('back.timeline');
       
    }
}

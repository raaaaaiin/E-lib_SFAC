<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Facades\Common;


class DiscoverController extends Common
{
   public function index(){
       return view("back.discover");
   }
  
 
}

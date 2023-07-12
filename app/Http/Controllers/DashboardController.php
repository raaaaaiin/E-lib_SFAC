<?php

namespace App\Http\Controllers;

use App\Facades\Util;
use App\Models\NoticeManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    //
  
    public function index($sdate){
        $notices_for_me = NoticeManager::where(function($query){$query->orWhereJsonContains("user_id", [Auth::id()])
            ->orWhereJsonContains("role_id", User::get_current_user_roles_in_array());})->whereIn("active",[1])->get();
        if(!app()->runningInConsole()) {
            if (!Cookie::has("license_check")) {
                Cookie::queue("license_check", Util::generateRandomString(5), 720); // checks once a day.
                \App\Facades\Util::checkLicense();
            }
        }
        return view("back.dashboard",compact("sdate"));
    }public function indexself(){
    $sdate = "Null";
        $notices_for_me = NoticeManager::where(function($query){$query->orWhereJsonContains("user_id", [Auth::id()])
            ->orWhereJsonContains("role_id", User::get_current_user_roles_in_array());})->whereIn("active",[1])->get();
        if(!app()->runningInConsole()) {
            if (!Cookie::has("license_check")) {
                Cookie::queue("license_check", Util::generateRandomString(5), 720); // checks once a day.
                \App\Facades\Util::checkLicense();
            }
        }
        return view("back.dashboard",compact("sdate"));
    }
}

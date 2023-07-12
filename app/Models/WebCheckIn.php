<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WebCheckin extends Model
{

use CustomCache;
use HasFactory;
protected $guarded = ['id'];


    protected $table ='web_checkin';
    public function insert($id){
 

$today= now();

$year = $today->year;
$month = $today->month;
$day =  $today->day;
$hour = $today->hour;
$weeknumber = $today->weekOfYear;
$weekMap = [
    0 => 'Sun',
    1 => 'Mon',
    2 => 'Tue',
    3 => 'Wed',
    4 => 'Thu',
    5 => 'Fri',
    6 => 'Sat',
];
$dayOfTheWeek = $today->dayOfWeek;
$weekday = $weekMap[$dayOfTheWeek];
$func = new User;
if(\Common::getCourseName($func->get_course($id)) == "--" || \Common::getCourseYearName($func->get_year($id)) =="--"){
    $section = "Undefined";
}else{
    $section = \Common::getCourseName($func->get_course($id))." ".\Common::getCourseYearName($func->get_year($id));
}
$user_meta_obj = UserMeta::where("user_id", $id)->first();
                
     WebCheckin::Create([
     "name" => $func->get_user_name($id),
     "section" =>  $section,
     "gender" => $user_meta_obj->get_gender(),
     "userID" => $id,
     "Date" => $today,
     "Month" => $month,
     "Day" => $day,
     "Year" => $year,
     "weekNumber" => $weeknumber,
     "weekDay" => $weekday,
     "Time" => $hour]);

    //id autoincrement
    //fname
    //lname
    //email
    //address - section
    //gender
    //studentid
    //date
    //time 24h period
    //month
    //day
    //year
    //weeknumber
    //weekday
    return "success";
    }
}


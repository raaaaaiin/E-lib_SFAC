<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course_Year extends Model
{
    //Making a relationship of course and course_year table
    protected $table = "course_courseyear";
    protected $guarded = ["id"];
}

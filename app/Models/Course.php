<?php

namespace App\Models;

use App\Facades\Common;
use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    use CustomCache;
    //use SoftDeletes;
    protected $table = "course";
    protected $fillable = ["name"];



    public static function getDivisions($std_id)
    {
        return CourseYear::where("std_id", $std_id)->get();
    }

    // Attaching Years to Course
    public static function saveYears(Course $standard, $values)
    {
        // Clear before setting new data.
        $courses = Course_Year::where("course_id", $standard->id)->get();
        foreach ($courses as $course) {
            $course->delete();
        }
        //dd($subject->id);
        foreach ($values as $val) {
            foreach ($val as $v) {
                Course_Year::create(["course_id" => $standard->id, "course_year_id" => $v]);
            }
        }
    }

    // Attaching Divisions to Standard
    public static function saveSemesters(Course $standard, $values)
    {
        // Clear before setting new data.
        $standards = Standard_Semester::where("std_id", $standard->id)->get();
        foreach ($standards as $sub) {
            $sub->delete();
        }
        //dd($subject->id);
        foreach ($values as $val) {
            foreach ($val as $v) {
                Standard_Semester::create(["std_id" => $standard->id, "semester_id" => $v]);
            }
        }
    }

}

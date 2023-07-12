<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CourseYear extends Model
{
    //
    use CustomCache;
    protected $table = "course_year";
    protected $guarded = ["id"];


}

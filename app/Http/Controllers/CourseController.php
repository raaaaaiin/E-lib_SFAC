<?php

namespace App\Http\Controllers;

use App\Facades\Common;

;

use App\Models\Course_Year;
use App\Models\CourseYear;
use App\Models\Setting;
use App\Models\Course;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Common::getAllCourses();
        return view("back.course.index", compact("courses"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $mode = "create";
        $course = new  Course();
        $course_years = Common::getAllCourseYears();
        #$semesters = Common::getAllSems();
        if (!count($course_years) || !count($course_years)) {
            Session::flash("alert-dark", __("course.kindly_create_years"));
        }
        return view("back.course.create_edit", compact("mode", "course", "course_years"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "course_year" => "required",
        ], ["name" => __("course.cs_name_req"),
            ]);
        if ($validator->fails()) {
            //Session::flash("alert-danger", $validator->errors()->getMessages());
            return redirect()->back()->withInput($request->all())
                ->withErrors($validator);
        }
        //dd($request->only(['div_name']));
        if ($request->has("submit")) {
            //$standard = Standard::create($request->only('std_name','std_fee'));
            $standard = new Course();
            $standard->name = $request->name;
            $standard->save();
            Course::saveYears($standard, $request->only("course_year"));


            Session::flash("alert-success", __("course.cs_saved"));
        }
        if ($request->submit == "save") {
            Session::flash("alert-success", __("course.cs_saved"));

            return redirect(route("course.index"));
        } else {
            return redirect(route("course.create"));
        }
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $mode = "edit";
        if (!$id) return redirect()->back();
        $course = Course::find($id);
        $course_years = Common::getAllCourseYears();
        return view("back.course.create_edit", compact("mode", "course", "course_years"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "course_year" => "required",
        ], ["name" => __("standard.std_name_req"),
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())
                ->withErrors($validator);
        }
        if ($request->has("submit")) {
            $course = Course::find($id);
            $course->name = $request->name;
            Course::saveYears($course, $request->only("course_year"));
            $course->fill($request->only(['name']))->save();

            //$standard->save();
            Session::flash("alert-success", __("course.cs_updated"));
        }
        if ($request->submit == "save") {
            Session::flash("alert-success", __("course.cs_updated"));
            return redirect(route("course.index"));
        } else {
            return redirect(route("course.create"));
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *

     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if ($id) {
            $tmp = Course::find($id);
            if ($tmp) {
                $tmp->delete();
                Course_Year::whereIn("course_id", [$id])->delete();
//                Standard_Subject::whereIn("std_id", [$id])->delete();
//                Standard_Semester::whereIn("std_id", [$id])->delete();
                //Setting::where("option_key", "current_sem_for_std_with_" . $id)->delete();
            }
            Session::flash("alert-success", __("course.cs_deleted"));
            return redirect()->back();
        }
        return redirect()->back();
    }



    // Consumed by the standard list page to set the default standard
    public function setCurrentSem(Request $request)
    {
        if ($request->sem_id && $request->std_id) {
            $opt_name = "current_sem_for_std_with_" . $request->std_id;
            Setting::updateOrCreate(["option_key" => $opt_name], ["option_key" => $opt_name, "option_value" => $request->sem_id]);
        }
        return redirect()->back();
    }

    // Consumed in invoice page
    public function getSemesters(Request $request)
    {
        $sem_ids = Standard_Semester::where("std_id", $request->std_id)->pluck("semester_id")->toArray();
        $semesters = Semester::whereIn("id", $sem_ids)->get()->toArray();
        return json_encode($semesters);
    }

    // Consumed in invoice page
    public function getRunningSemester(Request $request)
    {
        return json_encode(Common::getCurrentSemester($request->std_id));
    }

    // Consumed in invoice page
    public function getRolls(Request $request)
    {
        if ($request->std_id && $request->div_id) {
            return json_encode(Common::getAllRollNosOfClass($request->std_id, $request->div_id));
        }
    }
}

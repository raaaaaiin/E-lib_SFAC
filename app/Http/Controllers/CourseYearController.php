<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Models\Course_Year;
use App\Models\CourseYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CourseYearController extends Controller
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
        $courseYear = Common::getAllCourseYears();
        return view("back.course_year.index", compact("courseYear"));
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
        $courseYear = new  CourseYear();
        return view("back.course_year.create_edit", compact("mode", "courseYear"));
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
            "year" => "required"
        ]);
        if ($validator->fails()) {
            Session::flash("alert-danger", $validator->errors()->getMessages());
            return redirect()->back();
        }
        if ($request->has("submit")) {
            CourseYear::create($request->only(['year']));
            Session::flash("alert-success", __("course_year.cy_saved"));
        }
        if ($request->submit == "save") {
            Session::flash("alert-success", __("course_year.cy_saved"));
            return redirect(route("course-year.index"));
        } else {
            return redirect(route("course-year.create"));
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
        $courseYear = CourseYear::find($id);
        return view("back.course_year.create_edit", compact("mode", "courseYear"));
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
            "year" => "required",
        ], ["year" => __("course_year.cy_name_required")]);
        if ($validator->fails()) {
            Session::flash("alert-danger", $validator->errors()->getMessages());
            return redirect()->back();
        }
        if ($request->has("submit")) {
            CourseYear::find($id)->fill($request->only(['year']))->save();
            Session::flash("alert-success", __("course_year.cy_updated"));
        }
        if ($request->submit == "save") {
            Session::flash("alert-success", __("course_year.cy_updated"));
            return redirect(route("course-year.index"));
        } else {
            return redirect(route("course-year.create"));
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
        if ($id) {
            $tmp = CourseYear::find($id);
            if ($tmp) {
                Course_Year::whereIn("course_year_id", [$tmp->id])->delete();
                $tmp->delete();
            }
            Session::flash("alert-success", __("course_year.cy_deleted"));
            return redirect()->back();
        }
        return redirect()->back();
    }
}

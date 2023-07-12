<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Models\CourseYear;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
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
        $years = Common::getAllYears();
        return view("back.year.index", compact("years"));
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
        $year = new  Year();
        return view("back.year.create_edit", compact("mode", "year"));
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
            "year_from" => "required"
        ], ["year_from.required" => __("year.wrk_yr_req")]);
        if ($validator->fails()) {
            Session::flash("alert-danger", $validator->errors()->getMessages());
            return redirect()->back();
        }
        //dd($request->only(['div_name']));
        if ($request->has("submit")) {
            $year = Year::create($request->only(['year_from']));
            Session::flash("alert-success", __("year.yr_saved"));
        }
        if ($request->submit == "save") {
            Session::flash("alert-success", __("year.yr_saved"));
            return redirect(route("year.index"));
        } else {
            return redirect(route("year.create"));
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Year $year
     * @return \Illuminate\Http\Response
     */
    public function show(Year $year)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Year $year
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $mode = "edit";
        if (!$id) return redirect()->back();
        $year = Year::find($id);
        return view("back.year.create_edit", compact("mode", "year"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Year $year
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            "year_from" => "required",
        ], ["year_from.required" => __("year.wrk_yr_req")]);
        if ($validator->fails()) {
            Session::flash("alert-danger", $validator->errors()->getMessages());
            return redirect()->back();
        }
        if ($request->has("submit")) {
            CourseYear::find($id)->fill($request->only(['year_from']))->save();
            Session::flash("alert-success", __("year.yr_updated"));
        }
        if ($request->submit == "save") {
            Session::flash("alert-success", __("year.yr_updated"));
            return redirect(route("year.index"));
        } else {
            return redirect(route("year.create"));
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Year $year
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if ($id) {
            $tmp = Year::find($id);
            if ($tmp) {
                $tmp->delete();
            }
            Session::flash("alert-success", __("year.yr_del"));
            return redirect()->back();
        }
        return redirect()->back();
    }
}

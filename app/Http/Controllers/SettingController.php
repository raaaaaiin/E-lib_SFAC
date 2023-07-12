<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Models\Setting;
use App\Facades\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SettingController extends Controller
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
        $working_frm = "content_setting";
        $settings = Common::getAllSettingInArray();
        return view("back.setting", compact("working_frm", "settings"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        if ($request->has("purchase_code")) {
            $request = Util::checkLicense($request->get("purchase_code"), $request);
            Cookie::forget("license_check");
        }
        $working_frm = $request->frm_name;
        //dd($request->except("_token", "frm_name"));
        $ignore_items = ["_token", "frm_name", "web_ico_file", "org_logo_tmp"];
        if ($request->hasFile('web_ico_file')) {
            $file = $request->file('web_ico_file');
            $tmp = "favicon.ico";
            $file->move(public_path(), $tmp);
        }
        if ($request->hasFile('org_logo_tmp')) {
            $file = $request->file('org_logo_tmp');
            $tmp = Util::uploadFile($file, uniqid() . "_logo_." . $file->getClientOriginalExtension());
            $request->merge([
                'org_logo' => $tmp,
            ]);
        }

        foreach ($request->except($ignore_items) as $key => $value) {

            if ($key == "toggles" && is_array($value)) {
                // Converting any null values to 0
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if (is_null($v)) {
                            $value[$k] = 0;
                        }
                    }
                }
                $old_data = Setting::where("option_key", "toggles")->first();
                if ($old_data) {
                    $value = json_encode(array_merge(json_decode($old_data->option_value, true), $value));
                }
            }
            if (is_array($value)) {
                $value = json_encode($value);
            }
            if (!$value) {
                $value = '';
            }
            Setting::updateOrCreate(["option_key" => $key], ["option_key" => $key, "option_value" => trim($value)]);
        }
        session()->flash('form_setting', true);
        Session::flash("alert-success", __("common.opt_saved"));
        return redirect()->back()->withInput($request->all())->with(["working_frm" => $working_frm])
            ->withCookie("locale", $request->has("default_lang") ? $request->get("default_lang") : Common::getDefaultLang());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function clearCache(Request $request)
    {
        Util::clearCache();
        session()->flash('form_setting', true);
        Session::flash("alert-success", __("common.cleared_all_cache"));
        return redirect()->back()->with(["working_frm" => $request->frm_name]);
    }
}

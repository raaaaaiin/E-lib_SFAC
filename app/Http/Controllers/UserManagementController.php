<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Facades\Util;
use App\Models\Course;
use App\Models\CourseYear;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
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
        if (\request()->has("page_mode")) {
            $page_mode = \request()->get("page_mode");
            $course_id = \request()->get("course_id");
            $course_year = \request()->get("course_year");
            return view("back.user-mng", compact("page_mode", "course_id", "course_year"));
        }
        return view("back.user-mng");
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

    public function getUsers()
    {
        return json_encode(["data" => Common::getAllUsers()]);
    }

    public function importUser(Request $request)
    {
        Session::flash("form_list", true);
        if (!$request->has("file")) {
            Session::flash("alert-warning", __("common.no_file_selected"));
            return \redirect()->back();
        }
        $extension = File::extension($request->file->getClientOriginalName());
        if ($extension != "csv") {
            Session::flash("alert-danger", __("common.only_csv"));
            return redirect()->back();
        }
        \Artisan::call("backup:run"); // Creates a backup
        $new_filename = Util::uploadFile($request->file('file'));
        //$new_filename = "rDo_template.csv";
        $file_loc = "uploads/" . $new_filename;
        $header = array();
        $file = fopen($file_loc, "r");
        //Getting all the header in the file into array to compare it with the system db columns
        while (($data = fgetcsv($file)) !== FALSE) {
            // Lets read the header so as to get the column name
            for ($i = 0; $i < 60; $i++) {
                if (!empty($data[$i])) {
                    array_push($header, $data[$i]);
                } else {
                    break;
                    // We now have the headers
                }
            }
            break;
        }
        if (["NAME", 'USERNAME', "PASSWORD", "COURSE_ID", "COURSEYEAR_ID", "TYPE", "PHONE", "ACTIVE"] != $header) {
            Session::flash("alert-danger", __("common.colm_miss_match"));
            return \redirect()->back();
        }
        $found = false;
        while (($data = fgetcsv($file)) !== FALSE) {
            try {
                $data = array_map("strval", $data);
            } catch (\Exception $e) {
            }
            $data = array_map("utf8_encode", $data); //added
            $data = array_map("strval", $data);
            $name = trim($data[0]);
            $username = trim($data[1]);
            $password = $data[2] ?? '12345678';
            $course_id = $data[3];
            $courseyear_id = $data[4];
            $type = Str::lower($data[5]) ?? "student";
            $phone = $data[6] ?? "";
            $active = $data[7] ?? 1;
            // At least name and email should be fine
            if (!$name) {
                continue;
            }
            if (!$username) {
                continue;
            }
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            $user_obj = User::create(["email" => $username, "active" => $active, "name" => $name, "password" => \Hash::make($password)]);
            if ($user_obj) {
                if (Course::find($course_id) && CourseYear::find($courseyear_id)) {
                    UserMeta::create(["user_id" => $user_obj->id, "meta_key" => "assigned_to", "meta_value" => '[{"' . $course_id . '":"' . $courseyear_id . '"}]']);
                }
                if ($phone) {
                    UserMeta::create(["user_id" => $user_obj->id, "meta_key" => "phone", "meta_value" => $phone]);
                }
                if (in_array($type, ["teacher", "student"])) {
                    $user_obj->assignRole(Role::findByName($type)->name);
                }
                $found = true;
            }
        }
        if ($found) {
            Session::flash("alert-success", __("common.imported_success"));
        } else {
            Session::flash("alert-warning", __("common.nothing_imported"));
        }
        return redirect()->back();
    }
}

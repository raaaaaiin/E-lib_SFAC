<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\NoticeManager;
use Illuminate\Http\Request;


class AwardsController extends Controller
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
        return view("back.awards");
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
        $notice_obj = null;
        if ($request->mode == "create" && !isset($request->id)) {
            $notice_obj = new NoticeManager();
        } else {
            if (isset($request->id)) {                #
                $notice_obj = NoticeManager::find($request->id);
            } else {
                return json_encode(["message" => __("common.err_occ"), "title" => __("common.inf"), "type" => "error"]);
            }
        }
        $notice_obj->notice = !empty($request->notice) ? $request->notice : "N/A";
        $notice_obj->role_id = json_encode($request->give_to_role != null ? array_map('intval', $request->give_to_role) : []);
        $notice_obj->user_id = json_encode($request->give_to_user != null ? array_map('intval', $request->give_to_user) : []);
        if ($request->has('show_in') && !empty($request->show_in)) {
            $notice_obj->show_in = 'front_end';
        }
        $notice_obj->active = 1;
        $notice_obj->save();
        if ($request->mode == "update") {
            return json_encode(["message" => __("common.notice_upd_pushed"), "title" => __("common.inf"), "type" => "success"]);
        } else {
            return json_encode(["message" => __("common.notice_pushed"), "title" => __("common.inf"), "type" => "success"]);
        }
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
        //echo "he";
        if ($id) {
            return json_encode(["data" => NoticeManager::findorfail($id)]);
        }
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
}

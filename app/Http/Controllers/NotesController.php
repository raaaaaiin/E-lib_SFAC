<?php

namespace App\Http\Controllers;

use App\Facades\Util;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Notes::with("book")->has("book")->where("user_id", \Auth::id())->orderBy("id", "desc")->paginate(10);
        return view("back.note.index", compact("items"));
    }

    public function create()
    {
        $mode = "create";
        return view("back.note.create_edit", compact("mode"));
    }

    public function deleteNote($id)
    {
        \Session::flash("note_list", true);
        $tmp = Notes::find($id);
        if ($tmp) {
            $files_to_remove = $tmp->files_attached;
            Util::smartDelete("files_attached",public_path("uploads"),[$tmp],true);
            $tmp->delete();
            \Session::flash("alert-success", __("common.notes_status", ["status" => __("common.deleted")]));
            return redirect()->back();
        } else {
            \Session::flash("alert-danger", __("common.no_changes_has_been_made"));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $mode = "edit";
        $item = Notes::with("book")->where("user_id", \Auth::id())->where("id", $id)->first();
        return view("back.note.create_edit", compact("item", "mode"));
    }

    public function store(Request $request)
    {
        $validate_fields = [
            'note_desc' => "required",
            'note_title' => "required",
            'book_id' => "required",
            'note_status' => "required",
            'file.*' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:10000'];
        $validator = Validator::make($request->all(), $validate_fields);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())
                ->withErrors($validator);
        }
        \Session::flash("note_form", true);
        $request->merge([
            'user_id' => \Auth::id(),
        ]);
        $old_data = [];
        if ($request->mode == "edit") {
            if ($request->has("id")) {
                $note_obj = Notes::find($request->id);
                if ($note_obj) {
                    $old_data = (array)$note_obj->files_attached;
                }
            }
            if (!$request->has("files_attached")) {
                $request->merge([
                    'files_attached' => array(),
                ]);
            } else {
                $files_removed = array_diff($old_data, $request->files_attached);
                foreach ($files_removed as $file) {
                    File::delete(public_path('uploads' . '/' . $file));
                }
            }

        }
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            $file_names = [];
            foreach ($files as $file) {
                //array_push($file_names, Util::uploadFile($file, uniqid() . "." . $file->getClientOriginalExtension()), $file->getClientOriginalName());
                array_push($file_names, Util::uploadFile($file, \Auth::id() . "_" . $file->getClientOriginalName()));
            }
            if ($request->has("files_attached")) {
                $file_names = array_merge($file_names, $request->files_attached);
            }
            $request->merge([
                'files_attached' => $file_names,
            ]);
        }
        $tmp = Notes::updateOrCreate(["id" => $request->id], $request->except("_token", "submit", "id", "mode", "file"));
        if ($tmp) {
            \Session::flash("alert-success", __("common.notes_status", ["status" => __("common.saved")]));
        } else {
            \Session::flash("alert-danger", __("common.no_changes_has_been_made"));
        }
        if ($request->submit == "save_and_list") {
            \Session::flash("note_list", true);
            return redirect(route('notes-mng.index'));
        } else {
            Util::flashToOldSession($request->except("file"));
            return redirect()->back();
        }

    }
}

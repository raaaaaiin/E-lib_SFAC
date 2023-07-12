<?php

namespace App\Http\Livewire;

use App\Events\UserActivated;
use App\Events\UserCreated;
use App\Facades\Common;
use App\Facades\Util;
use App\Models\Borrowed;
use App\Models\User;
use App\Models\UserMeta;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserMng extends Component
{
    use WithFileUploads;

    private $users;
    use WithPagination;
    use CustomCommonLive;

    protected $paginationTheme = 'bootstrap';
    public $full_name;
    public $stdid;
    public $email;
    public $gender;
    public $address;
    public $phone;
    public $photo;
    public $about_me;
    public $mode = "create";
    public $password;
    public $password_confirmation;
    public $photo_link = "";
    public $submit_status = true;
    public $roles;
    public $filter_role = 'student';
    public $filter_name;
    public $assigned_to = array();
    public $selcourse;
    public $sel_year;
    public $edit_id;
    public $form_mode = "";
    public $sel_uid = [];
    protected $listeners = ["deleteUser","selcourse", "deleteThisEntry", "changeUserStatus", "deleteBulk", "confirm"];
    public $attached_role_ids = array();
    public $user_in_choosen_class = [];
    public $page_mode;
    public $course_year;
    public $course_id;
    public $filter_keyword;
    public $all_courses = [];
    public $all_course_years = [];
    public $selected_course_id;
    public $selected_course_year_id;
    public $selectAll = false;
    public $currently_showing_ids = [];
    public $foo;

    public function updatedFoo()
{

}
    public function updatedSelcourse(){
  
    }
    public function updatedSelectedCourseId()
    {
        $this->all_course_years = \App\Models\Course_Year::where("course_id", $this->selected_course_id)->get();
    }

    public function mount()
    {
        $this->photo_link = config("app.DEFAULT_USR_IMG");
        $this->attached_role_ids = [Common::getDafaultRole()];
        $this->roles = Common::getAllRoles();
    }

    public function updatedSelectAll()
    {
//        if ($this->page_mode == "promotion") {
//            $this->sel_uid = $this->user_in_choosen_class;
//        }
        if ($this->selectAll) {
            $this->sel_uid = $this->currently_showing_ids;
        } else {
            $this->sel_uid = [];
        }
    }

    public function render()
    {
        if ($this->page_mode == "promotion") {
            $this->all_courses = Common::getAllCourses();
        }
        $tmp = null;
        if ($this->filter_role !== "in_active") {
            $tmp = (new User)->get_active();
        } else {
            $tmp = (new User)->get_in_active();
        }
        $matched_ids = [];
        if ($this->filter_keyword) {
            $address_matched = UserMeta::where("meta_key", "address")->where("meta_value", "like", "%" . $this->filter_keyword . "%")
                ->get()->pluck("user_id")->toArray();
            $phones_matched = UserMeta::where("meta_key", "phone")->where("meta_value", "like", "%" . $this->filter_keyword . "%")
                ->get()->pluck("user_id")->toArray();
            $matched_ids = array_merge($address_matched, $phones_matched);
            $datas = User::query()->where(function ($query) {
                $query->where("name", "like", "%" . $this->filter_keyword . "%")->orwhere("email", "like",
                    "%" . $this->filter_keyword . "%")->orWhere("id", $this->filter_keyword);
            })->get()->pluck("id")->toArray();
            $matched_ids = array_merge($matched_ids, $datas);
        }
        if (!empty($this->filter_role) && $this->filter_role != "in_active") {
            $user_with_role = User::get_users_by_role($this->filter_role)->pluck("id")->toArray();
            if (count($matched_ids)) {
                $user_with_role = array_intersect($user_with_role, $matched_ids);
            }
            $tmp = $tmp->whereIn("id", $user_with_role);
        }
        if (!empty($this->course_year) && !empty($this->course_id)) {
            $this->user_in_choosen_class = UserMeta::where("meta_value",
                '[{"' . $this->course_id . '":"' . $this->course_year . '"}]')->get()->pluck("user_id")->toArray();
            $tmp = $tmp->whereIn("id", $this->user_in_choosen_class);
        }
        if ($this->page_mode == "promotion") {
            $tmp = $tmp->orderBy("id", "desc")->get();
        } else {
            $tmp = $tmp->orderBy("id", "desc")->paginate(10);
        }
        if ($this->page_mode != "promotion") {
            foreach ($tmp->items() as $item) {
                array_push($this->currently_showing_ids, $item->id);
            }
            $this->resetPage();
        } else {
            foreach ($tmp as $item) {
                array_push($this->currently_showing_ids, $item->id);
            }
        }

        $this->dispatchBrowserEvent("tooltip_refresh");
        return view('livewire.user-mng', ["users" => $tmp]);
    }

    public function assign()
    {
        session()->flash("form_user", true);
    
        if ($this->selcourse && $this->sel_year) {
            if (!$this->assigned_to) {
                $this->assigned_to = array();
            }
            array_push($this->assigned_to, array($this->selcourse => $this->sel_year));
            $this->assigned_to = array_unique($this->assigned_to, SORT_REGULAR);
        } else {
            session()->flash("alert-danger", __("common.data_missing"));
        }
    }

    public function changeUserStatus($datas)
    {

        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $user_obj = User::find($id);
            if ($user_obj) {
                $tmp = $user_obj->active;
                $user_obj->active = !$user_obj->active;
                $user_obj->save();

                if ($tmp) {
                    $this->sendMessage(__("common.user_deadmitted_success", ["name" => $user_obj->name]), "success");
                } else {
                    $this->sendMessage(__("common.user_admitted_success", ["name" => $user_obj->name]), 'success');
                }
                if ($user_obj->active) {
                    try {
                        $user_obj->called_via = "Form Activation";
                        UserActivated::dispatch($user_obj);
                    } catch (\Exception $e) {
                    }
                }
            }
        } else {
            $this->sendMessage(__("common.id_missing"), "error");
        }

    }

    public function deleteThisEntry($datas)
    {
        $tmp = array();
        $datas = Util::getCleanedLiveArray($datas);
        $cs = isset($datas["cs_id"]) ? $datas["cs_id"] : 0;
        $cy = isset($datas["cy_id"]) ? $datas["cy_id"] : 0;

        if (count($this->assigned_to)) {
            foreach ($this->assigned_to as $teach) {
                try {
                    if ($teach[$cs] != $cy) {
                    }
                } catch (\Exception $e) {
                    array_push($tmp, $teach);
                }
            }
            $this->assigned_to = $tmp;
        }
    }

    public function toggleUserStatus()
    {
        $ids = $this->sel_uid;
        if (is_countable($ids) && count($ids)) {
            foreach ($ids as $id) {
                $user_obj = User::find($id);
                if ($user_obj) {
                    $user_obj->active = !(int)$user_obj->active;
                    $user_obj->save();
                }
            }
            $this->sel_uid = [];
            $this->sendMessage(__("common.status_saved"), "success");
        } else {
            $this->sendMessage(__("common.nothing_has_been_selected"));
        }
    }

    public function printIdCards()
    {
        $ids = $this->sel_uid;
        if (is_countable($ids) && count($ids)) {
            return redirect(route('print_id_cards', ["ids" => bin2hex(implode(",", $ids))]));
        } else {
            $this->sendMessage(__("common.nothing_has_been_selected"));
        }
    }

    public function promoteUsers()
    {
        $ids = $this->sel_uid;
        if (is_countable($ids) && count($ids)) {
            $course_id = $this->selected_course_id;
            $course_year_id = $this->selected_course_year_id;
            UserMeta::whereIn("user_id", $ids)->where("meta_key", "assigned_to")->update(["meta_value" => '[{"' . $course_id . '":"' . $course_year_id . '"}]']);
            $this->sendMessage(__("commonv2.user_promoted_msg"),"success");
        } else {
            $this->sendMessage(__("common.nothing_has_been_selected"));
        }
    }

    public function saveUser()
    {
        session()->flash("form_user", true);
        $this->validate([
            'photo' => 'nullable|image|max:1024', // 1MB Max
            "full_name" => "required",
            "stdid" => "required",
           
        ], [
            "photo.image" => __("common.only_image"),
            "photo.max" => __("common.file_size_exceed"),
        ]);
        if ($this->mode == "create") {
            $this->validate([
                "password" => "required|min:8|confirmed"], [
                "password.required" => __("common.password_req"),
                "password.min" => __("common.password_8_char_long"),
                "password.confirmed" => __("common.password_and_confirm_password_dont_match")
            ]);
        }
        $user_obj = null;
        if ($this->mode == "create") {
            $user_obj = User::create([
                "email" => $this->email,
                "name" => $this->full_name,
                "id" => $this->stdid,

                "password" => Hash::make(trim($this->password_confirmation)), "active" => 1
            ]);

        } else {
      
            $to_update = ["name" => $this->full_name,"id" => $this->stdid, "email" => $this->email];
            if (!empty($this->password_confirmation)) {
                $to_update["password"] = Hash::make($this->password_confirmation);
            }
           

            $user_obj = User::updateOrCreate(["id" => $this->stdid], $to_update);
             
           
        }
        if ($user_obj) {
        $user_obj->id = $this->stdid;
            if ($this->attached_role_ids) {
                $user_obj->roles()->sync($this->attached_role_ids);
            }
            $path = config("app.DEFAULT_USR_IMG");;
            if ($this->photo) {
                $path = $this->photo->storePublicly('', 'custom');
                UserMeta::updateOrCreate(["meta_key" => "photo", "user_id" => $user_obj->id], ["meta_value" => $path]);
                $this->photo_link = $path;
            }
            UserMeta::updateOrCreate(["meta_key" => "assigned_to", "user_id" => $user_obj->id], ["meta_value" => json_encode($this->assigned_to)]);
            //UserMeta::updateOrCreate(["meta_key" => "div_id", "user_id" => $user_obj->id], ["meta_value" => $this->sel_year]);
            UserMeta::updateOrCreate(["meta_key" => "address", "user_id" => $user_obj->id], ["meta_value" => $this->address]);
            UserMeta::updateOrCreate(["meta_key" => "phone", "user_id" => $user_obj->id], ["meta_value" => $this->phone]);

            UserMeta::updateOrCreate(["meta_key" => "about_me", "user_id" => $user_obj->id], ["meta_value" => $this->about_me]);
            UserMeta::updateOrCreate(["meta_key" => "gender", "user_id" => $user_obj->id], ["meta_value" => $this->gender]);
            //$this->users = User::all();
            $user_obj->password = $this->password_confirmation;
            if ($this->mode == "create") {
                try {
                    UserCreated::dispatch($user_obj);
                } catch (\Exception $e) {//ignoring the error but logging it.
                }
            }
            $this->editUser($this->sel_uid);
            session()->flash("alert-success", __("common.usr_has_been", ["status" => __($this->mode == "create" ? "common.created" : "common.updated")]));
            $this->roles = Common::getAllRoles();
            
        }
    }

    public
    function clearAll()
    {
        $this->full_name = "";
        $this->stdid = "";
        $this->email = "";
        $this->address = "";
        $this->phone = "";
        $this->about_me = "";
        $this->photo_link = config("app.DEFAULT_USR_IMG");;
        $this->mode = "create";
        $this->assigned_to = [];
        $this->clearValidation();
    }

    public
    function updatedEmail($value)
    {
        if (User::where("email", trim($value))->exists() && $this->mode == "create") {
            $this->submit_status = false;
            throw ValidationException::withMessages(['email' => __('common.no_email_tmp_exist')]);
        } else {
            $this->submit_status = true;
            throw ValidationException::withMessages(['email' => '']);
        }
    }

    public function addUserBtn()
    {
        $this->form_mode = "add";
    }

    public function closeUserFormBtn()
    {
        $this->form_mode = "";
    }

    public function deleteBulk()
    {
        $ids = $this->sel_uid;
        if (count($ids)) {
            foreach ($ids as $id) {
                $user_obj = User::find($id);
                if ($user_obj) {
                    UserMeta::whereIn("user_id", [$user_obj->id])->delete();
                    Borrowed::whereIn("user_id", [$user_obj->id])->delete();
                    $user_obj->delete();
                }
            }
            $this->sel_uid = [];
            $this->sendMessage(__("common.usrs_deleted"), "success");
        } else {
            $this->sendMessage(__("common.nothing_has_been_selected"), "info");
        }
    }

    public
    function deleteUser($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $user_obj = User::find($id);
            if ($user_obj) {
                UserMeta::whereIn("user_id", [$user_obj->id])->delete();
                Borrowed::whereIn("user_id", [$user_obj->id])->delete();
                $user_obj->delete();
            }
            $this->sendMessage(__("common.usr_deleted"), "success");
        } else {
            $this->sendMessage(__("common.id_missing"), "error");
        }
    }

    public
    function editUser($id)
    {
        $this->mode = "edit";
        if ($id) {
            $user_obj = User::find($id);
            if ($user_obj) {
                $this->form_mode = "edit";
                $this->edit_id = $id;
                $this->full_name = $user_obj->name;
                $this->stdid = $user_obj->id;
                $this->email = $user_obj->email;
                $user_meta_obj = UserMeta::where("user_id", $user_obj->id)->first();
                if ($user_meta_obj) {
                    $this->address = $user_meta_obj->get_address();
                    $this->phone = $user_meta_obj->get_phone();
                    $this->about_me = $user_meta_obj->get_about_me();
                    $this->gender = $user_meta_obj->get_gender();
                    $this->photo_link = $user_meta_obj->get_user_photo();
                    $this->assigned_to = json_decode($user_meta_obj->get_assign(), true);
                    //$this->selcourse = $user_meta_obj->get_std();
                    $this->attached_role_ids = User::find($id)->roles->pluck("id");
                }
                if(empty($user_meta_obj->get_gender())){
                $this->gender = "MALE";
                }
            }
        }
    }
}

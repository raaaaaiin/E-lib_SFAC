<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\NoticeManager;
use App\Models\UserNotif;
use Livewire\Component;
use Livewire\WithPagination;

class Notice extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $notices;
    public $show_in = "back_end";
    public $give_to_user = array();
    public $give_to_role = array();
    public $notice;
    public $mode = "create";
    public $selected_id;
    public $give_to_user_holder, $give_to_role_holder;
    protected $listeners = ['data_manager', "deleteNotice"];

    public function data_manager($datas)
    {
        if (isset($datas["give_to_user"])) {
            $this->give_to_user = $datas["give_to_user"];
        }
        if (isset($datas["give_to_role"])) {
            $this->give_to_role = $datas["give_to_role"];
        }
    }

    public function render()
    {
        $this->dispatchBrowserEvent("refresh");
        return view('livewire.notice', ["notices" => NoticeManager::paginate(10)]);
    }

    public function noticeStatus($id, $active_status)
    {
    $notifinfo = [];
        $notice_obj = NoticeManager::find($id);
        if ($notice_obj) {
        
            $notice_obj->active = $active_status;
            
            $notice_obj->save();
            if($active_status = 0){
            dd($active_status);
               array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Activated Notice " ,"Target" => $notice_obj->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Notice","isread" => 0]);
            \Session::flash("alert-success", __("common.notice_upd_pushed"));
        }else{
        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Archived Notice " ,"Target" => $notice_obj->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Notice","isread" => 0]);
            \Session::flash("alert-success", __("common.notice_upd_pushed"));
        }
         
        }
    }

    public function updatedShowIn()
    {
        if ($this->show_in == "front_end") {
            $this->give_to_role_holder = $this->give_to_user_holder = "d-none";

        } else {
            $this->give_to_role_holder = $this->give_to_user_holder = "";
        }
    }

    public function editNotice($id)
    {
        $this->selected_id = $id;
        $this->mode = "edit";
        $notice_obj = NoticeManager::find($id);
        if ($notice_obj) {
            $this->notice = $notice_obj->notice;
            $this->give_to_role = $notice_obj->role_id;
            $this->give_to_user = $notice_obj->user_id;
            $this->show_in = $notice_obj->show_in;
            $this->dispatchBrowserEvent("refresh");
        }
    }

    public function add_notice()
    {
        session()->flash("form_notice", true);
        $notice_obj = null;
        if ($this->mode == "create" && !isset($this->selected_id)) {
            $notice_obj = new NoticeManager();
        } else {
            if (isset($this->selected_id)) {                #
                $notice_obj = NoticeManager::find($this->selected_id);
            } else {
                \Session::flash("alert-danger", __("common.id_missing"));
            }
        }
        if (empty($this->notice)) {
            session()->flash("alert-danger", __("common.notice_cannot_be_left_blank"));
            return;
        }
        if (is_array($this->give_to_role)) {
            $this->give_to_role = array_map("intval", $this->give_to_role);
        }
        if (is_array($this->give_to_user)) {
            $this->give_to_user = array_map("intval", $this->give_to_user);
        }
        $temp = !empty($notice_obj->notice) ? $notice_obj->notice : "N/A";
        $notice_obj->notice = !empty($this->notice) ? $this->notice : "N/A";
        $notice_obj->role_id = $this->give_to_role;
        $notice_obj->user_id = $this->give_to_user;
        $notice_obj->show_in = $this->show_in;
        $notice_obj->active = 1;
        $notice_obj->save();

        if ($this->mode == "update"){
         $notifinfo = [];
                        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Updated Notice " ,"Target" => $this->notice,"Modifier" => "to".$temp));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Notice","isread" => 0]);
            \Session::flash("alert-success", __("common.notice_upd_pushed"));

        } else {
         $notifinfo = [];
                        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Posted New Notice " ,"Target" => $this->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Notice","isread" => 0]);
            \Session::flash("alert-success", __("common.notice_pushed"));
        }
        $this->reset();
        $this->dispatchBrowserEvent("refresh");
    }

    public function deleteNotice($datas)
    {
        session()->flash("form_notice", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $obj = NoticeManager::where("id", $id)->first();
            if ($obj) {
                $obj->delete();
                $this->reset();
                session()->flash("alert-success", __("common.del_notice"));
                $this->dispatchBrowserEvent("refresh");
            }
        } else {
            session()->flash("alert-danger", __('common.id_missing'));
        }
    }
}

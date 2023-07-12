<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\HolidaysManager;
use App\Models\UserNotif;
use Livewire\Component;
use Livewire\WithPagination;

class Holidays extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $notices;
    public $issue_date_tmp;
    public $reason;
    public $coverage;
    public $range;
    public $to_date;
    public $mode = "create";
    public $selected_id;
    public $give_to_user_holder, $give_to_role_holder;
    protected $listeners = ['data_manager', "deleteNotice"];

    public function data_manager($datas)
    {
        if (isset($datas["issue_date"])) {
            $this->issue_date_tmp = $datas["issue_date"];
        }if (isset($datas["to_date"])) {
            $this->to_date = $datas["to_date"];
        }
        if (isset($datas["give_to_role"])) {
            $this->give_to_role = $datas["give_to_role"];
        }
    }

    public function render()
    {
        $this->dispatchBrowserEvent("refresh");
        return view('livewire.holidays', ["notices" => HolidaysManager::orderby("id",'DESC')->paginate(10)]);
    }

    public function noticeStatus($id, $active_status)
    {
    $notifinfo = [];
        $holiday_obj = HolidaysManager::find($id);
        if ($holiday_obj) {
        
            $holiday_obj->active = $active_status;
            
            $holiday_obj->save();
            if($active_status = 0){
               array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Posted Holiday " ,"Target" => $holiday_obj->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Holidays","isread" => 0]);
            \Session::flash("alert-success", __("common.notice_upd_pushed"));
        }else{
        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Archived Holiday " ,"Target" => $holiday_obj->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Holidays","isread" => 0]);
            \Session::flash("alert-success", "Holiday/Suspension Posted");
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
        $holiday_obj = HolidaysManager::find($id);
        if ($holiday_obj) {
            $this->reason = $holiday_obj->notice;
            $this->issue_date_tmp = $holiday_obj->noticedate;
            $this->dispatchBrowserEvent("refresh");
        }
    }

    public function add_notice()
    {
        session()->flash("form_notice", true);
        $holiday_obj = null;
        if ($this->mode == "create" && !isset($this->selected_id)) {
            $holiday_obj = new HolidaysManager();
        } else {
            if (isset($this->selected_id)) {                #
                $holiday_obj = HolidaysManager::find($this->selected_id);
            } else {
                \Session::flash("alert-danger", __("common.id_missing"));
            }
        }
        if (empty($this->reason)) {
            session()->flash("alert-danger", __("common.notice_cannot_be_left_blank"));
            return;
        }
        if(isset($this->to_date)){
           if(strtotime($this->issue_date_tmp) > strtotime($this->to_date)){
         session()->flash("alert-danger", "Range cannot be larger than initial date");
            return;
        }else{
            if($this->coverage == "Yearly"){
       $this->to_date = substr($this->to_date,0,-4). 'xxxx'; 
        }
        }
        }else{
        
        }
        
        if($this->coverage == "--"){
         session()->flash("alert-danger", "Coverage cannot be blank");
            return;
        }
        if($this->coverage == "Yearly"){
        $this->issue_date_tmp = substr($this->issue_date_tmp,0,-4). 'xxxx';
       
        }
        $temp = !empty($holiday_obj->reason) ? $holiday_obj->reason : "N/A";
        $holiday_obj->notice = !empty($this->reason) ? $this->reason : "N/A";
        $holiday_obj->noticedate = $this->issue_date_tmp;
        $holiday_obj->noticetodate = $this->to_date;
        $holiday_obj->active = 1;
        $holiday_obj->save();

        if ($this->mode == "update"){
         $notifinfo = [];
                      array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Updated Holiday " ,"Target" => $holiday_obj->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Holidays","isread" => 0]);
            \Session::flash("alert-success", "Holiday/Suspension Updated");

        } else {
         $notifinfo = [];
                        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Posted Holiday " ,"Target" => $holiday_obj->notice,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Holidays","isread" => 0]);
            \Session::flash("alert-success","Holiday/Suspension Posted");
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
            $obj = HolidaysManager::where("id", $id)->first();
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

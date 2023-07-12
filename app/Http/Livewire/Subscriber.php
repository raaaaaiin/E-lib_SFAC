<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use Livewire\Component;
use Livewire\WithPagination;

class Subscriber extends Component
{
    public $email;
    public $email_status = 0;
    //public $subscribers;
    public $mode = "create";
    public $selected_id = 0;
    protected $listeners = ["data_manager", "deleteSubscriber"];
    //public $tmp_email_status;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function data_manager($datas)
    {
        $this->email_status = $datas["email_status"];
        $this->refresh();
    }

    public function render()
    {
        $this->refresh();
        return view('livewire.subscriber', ["subscribers" => \App\Models\Subscriber::paginate(10)]);
    }

    public function saveSubscriber()
    {
        session()->flash("form_subscriber", true);
        $this->validate([
            "email" => "required|email",
        ], ["email.required" => __("common.email_req")]);
        if (!empty($this->email)) {
            $tmp_status = 0;
            if (!empty($this->email_status)) {
                $tmp_status = 1;
            }
            if ($this->mode == "create") {
                \App\Models\Subscriber::create(["email" => $this->email, "active" => $tmp_status]);
            } else {
                \App\Models\Subscriber::where("id",$this->selected_id)->update(["email"=>$this->email,"active" => $tmp_status]);
            }
            $this->email = "";
            $this->email_status = "";
            //$this->subscribers = \App\Subscriber::all();
            session()->flash("alert-success", __("common.subs_status",
                ["status" => $this->mode == "create" ? __("common.created") : __("common.updated")]));
            $this->reset();
            $this->refresh();
        }
    }

    public function editSubscriber($id)
    {
        if ($id) {
            $this->mode = "edit";
            $sub_obj = \App\Models\Subscriber::find($id);
            if ($sub_obj) {
                $this->selected_id = $id;
                $this->email = $sub_obj->email;
                $this->email_status = $sub_obj->active;
            }
        }
        $this->refresh();
    }

    public function deleteSubscriber($datas)
    {
        session()->flash("form_subscriber", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $sub_obj = \App\Models\Subscriber::find($id);
            if ($sub_obj) {
                $sub_obj->delete();
                //$this->subscribers = \App\Subscriber::all();
                $this->reset();
                session()->flash("alert-success", __("common.subs_deleted"));
            }
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }

    public function refresh()
    {
        $this->dispatchBrowserEvent('init_toggle_btns');
    }

//    public function email_status($id)
//    {
//        if ($id) {
//            \App\Subscriber::create(["email" => $this->email], ["active" => $this->tmp_email_status]);
//            $this->subscribers = \App\Subscriber::all();
//            session()->flash("message", "Subscriber status updated !.");
//        }
//    }
}

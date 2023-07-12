<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\ContactUs;
use App\Models\UserNotif;
use App\Traits\CustomCommonLive;
use Livewire\Component;

class Enquiries extends Component
{
    protected $listeners = ["delete"];
    public function load_data()
    {
        $this->contacts = ContactUs::orderBy("id", "desc")->paginate(10);
    }

    public
    function render()
    {
        $this->load_data();
        return view('livewire.enquiries', ["contacts" => $this->contacts]);
    }

    public
    function read($id, $do)
    {
        $tmp = ContactUs::find($id);
        if ($tmp) {
            $tmp->read = $do;
            $tmp->save();
            $this->load_data();
            $notifinfo = [];
            array_push($notifinfo, array( "User"  =>  \Auth::Id() ,"Action" => "Read Enquiries of" ,"Target" => $tmp->email ,"Modifier" => $tmp->message));

                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Enquiries","isread" => 0]);
        }
    }

    public
    function delete($datas)
    {
    
        session()->flash("form_enquiries", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $tmp = ContactUs::find($id);
            if ($tmp) {
                $tmp->delete();
                session()->flash("alert-success", __("common.enq_deleted"));
                $this->load_data();
                
     $notifinfo = [];
                        array_push($notifinfo, array( "User"  =>  \Auth::Id() ,"Action" => "Deleted Enquiries of" ,"Target" => $tmp->email ,"Modifier" => $tmp->message));

                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Enquiries","isread" => 0]);
            }
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }

    }
}

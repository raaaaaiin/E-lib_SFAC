<?php

namespace App\Http\Livewire;

use App\Models\ContactUs;
use App\Models\UserNotif;
use Livewire\Component;

class SendEnquiry extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    public function render()
    {
        return view('livewire.send-enquiry');
    }

    public function sendMessage()
    {
        \Session::flash("frm_contact_us", true);
        $this->validate(["name" => "required", "email" => "required|email", "subject" => "required", "message" => "required|min:10"]);
        $resp = ContactUs::updateOrCreate(["name" => $this->name, "email" => $this->email, "subject" => $this->subject, "message" => $this->message]);
        $this->reset();
        if ($resp) {
        $notifinfo = [];
                        array_push($notifinfo, array( "User"  => "There's New enquiry","Action" => "must check it out! " ,"Target" => "" ,"Modifier" => ""));

                        UserNotif::Create(["user_id" => "","meta_value" => json_encode($notifinfo),"meta_key" => "Enquiries","isread" => 0]);
            \Session::flash("alert-success", __("common.enquiry_has_been_submitted"));
        } else {
            \Session::flash("alert-danger", __("common.some_error_occured"));
        }

    }
}

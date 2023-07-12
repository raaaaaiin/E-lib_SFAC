<?php

namespace App\Http\Livewire\Partial;

use App\Events\SubscriberSubscribed;
use App\Facades\Util;
use App\Models\User;
use App\Traits\CustomCommonLive;
use Livewire\Component;

class PartialFrontSubscribe extends Component
{
    public $sub_email;
    use CustomCommonLive;
    public function render()
    {
        return view('livewire.partial.partial-front-subscribe');
    }

    public function save_sub()
    {
        session()->flash('form_front_subs', true);
        $this->validate(["sub_email" => "required|email"],
            ["sub_email.required" => __("common.sub_email_id_req"),
                "sub_email.email" => __("common.sub_email_id_invd")]);
        if (!empty($this->sub_email)) {
            $sub_obj = \App\Models\Subscriber::create(["email" => $this->sub_email, "code" => Util::generateRandomString(8), "active" => 0]);
            try {
                SubscriberSubscribed::dispatch($sub_obj);
                session()->flash("alert-success", __("subscriber.verify_email_to_get_lst_upd"));
            } catch (\Exception $e) {
                session()->flash("alert-warning", __("subscriber.mail_server_down"));
            }
            $this->sub_email = "";
        }
    }
}

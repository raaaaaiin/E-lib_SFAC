<?php

namespace App\Http\Livewire;

use App\Events\SubscriberSubscribed;
use App\Facades\Util;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontSubscribe extends Component
{
    public $email;
    use CustomCommonLive;
    public function saveSubscriber()
    {
        $this->validate(["email" => "required|email|unique:subscribers,email"],
            ["email.unique"=>__("common.you_have_already_sub")]);
        $sub = \App\Models\Subscriber::create(["email" => $this->email,"code" => Util::generateRandomString(5)]);
        $this->email = "";
        SubscriberSubscribed::dispatch($sub);
        $this->sendMessage(__("common.you_have_been_subscribed"),"success");
    }

    public function render()
    {
        return view('livewire.front-subscribe');
    }
}

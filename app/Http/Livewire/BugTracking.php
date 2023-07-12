<?php

namespace App\Http\Livewire;

use App\Traits\CustomCommonLive;
use Livewire\Component;

class BugTracking extends Component
{
    public $name;
    public $email;
    public $subject = "bug";
    public $message;
    public $page;
    use CustomCommonLive;
    public function mount()
    {
        $this->page = request()->url();
    }

    public function render()
    {
        return view('livewire.bug-tracking');
    }

    public function sendBugInfo()
    {
        $dev_email = config("app.DEVELOPER_EMAIL");
        if (!empty(trim($dev_email))) {
            mail($dev_email, $this->subject,
                "Page: " . $this->page . "<br>Name :" . $this->name . ".<br>Subject :" . $this->subject . "<br>Message:" . $this->message);
            $this->reset();
            $this->sendMessage("Message has been sent.","success");
        }
    }
}

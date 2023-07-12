<?php

namespace App\Listeners;

use App\Events\SubscriberSubscribed;
use App\Models\User;
use App\Notifications\MailVerification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use phpDocumentor\Reflection\Types\Object_;

class VerificationEmailSubscriberNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SubscriberSubscribed $event
     * @return void
     */
    public function handle(SubscriberSubscribed $event)
    {
        //
        //$demo = (object)["email"=>$event->subscriber_obj->email];
        //$demo = new User();
        //$demo->email = "kela@re.com";
        \Notification::send($event->subscriber_obj, new MailVerification($event->subscriber_obj));
    }


}

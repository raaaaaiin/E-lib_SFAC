<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Notifications\MailWelcomeUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class WelcomeMessageToUserNotification
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle($event)
    {
        //
        Notification::send($event->user_obj,new MailWelcomeUser($event->user_obj));
    }
}

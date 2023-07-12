<?php

namespace App\Providers;

use App\Events\SubscriberSubscribed;
use App\Events\UserActivated;
use App\Events\UserCreated;

use App\Listeners\VerificationEmailSubscriberNotification;
use App\Listeners\WelcomeMessageToUserNotification;
use App\Notifications\MailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SubscriberSubscribed::class => [VerificationEmailSubscriberNotification::class],
        UserCreated::class => [WelcomeMessageToUserNotification::class],
        UserActivated::class=>[WelcomeMessageToUserNotification::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Notifications;

use App\Facades\Common;
use App\Facades\Util;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class MailVerification extends Notification
{
    use Queueable;
    public $subscriber_obj;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscriber_obj)
    {
        //
        $this->subscriber_obj = $subscriber_obj;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from($address = Common::getSiteSettings("system_email", env('MAIL_FROM_ADDRESS')), $name = env("APP_NAME") . " System")
            ->subject(__("common.verification_email"))
            ->line(__("common.you_are_almost_there"))
            ->line(__("common.click_the_link_to_verify"))
            ->line(__("common.this_link_will_expire_in_7d"))
            ->action(__("common.verify_email_id"), url('/') . "/verify-email?code=" . $this->subscriber_obj->code . "&email=" . $this->subscriber_obj->email)
            ->line(new HtmlString(__("common.if_u_did_not_make_request_ignore")));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}

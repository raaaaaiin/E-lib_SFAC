<?php

namespace App\Notifications;

use App\Facades\Common;
use App\Models\UserMeta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class MailWelcomeUser extends Notification
{
    use Queueable;
    public $user_obj;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_obj)
    {
        //
        $this->user_obj = $user_obj;
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
        //$user_obj->called_via="Form Activation"
        $mail_obj = (new MailMessage)
            ->from($address = Common::getSiteSettings("system_email", env('MAIL_FROM_ADDRESS')), $name = env("APP_NAME") . " System")
            ->subject(__("common.welcome").' ' . $this->user_obj->name . " to " . Common::getOrgName() .' '. __("common.portal") . ".");
        if ($this->user_obj->called_via == "Form Activation") {
            $mail_obj = $mail_obj->line(__("common.your_accnt_has_been_activated"));
        } else {
            $mail_obj = $mail_obj->line(__("common.you_hv_now_been_added_as_an_user_into_system"));
        }
        $mail_obj = $mail_obj->line(__("common.your_usr_name") . ' : ' . $this->user_obj->email);
        if ($this->user_obj->called_via == "Form Activation") {
            $mail_obj = $mail_obj->line(__("common.your_passwd") . ' : *********');
        } else {
            $mail_obj = $mail_obj->line(__("common.your_passwd") . ' : ' . $this->user_obj->password);
        }
        $mail_obj = $mail_obj->action(__("common.visit_to_login"), url('/') . '/login')
            ->line(new HtmlString("<b>".__("common.note").":</b> ".__("common.kindly_chng_passwd_after_login")))
            ->line(new HtmlString(__("common.if_u_did_not_make_request_ignore")));
        return $mail_obj;
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

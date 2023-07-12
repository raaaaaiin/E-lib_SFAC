<?php

namespace App\Traits;

use function PHPUnit\Framework\assertGreaterThanOrEqual;

trait CustomCommonLive
{
    /**
     * @param int $time in-milli sec
     */
    public function showLoading($time = 300)
    {
        $this->dispatchBrowserEvent("show_loading", ["time" => $time]);
    }

    /**
     * @param int $time in-milli sec
     */
    public function closeLoading($time = 300)
    {
        $this->dispatchBrowserEvent("show_loading", ["time" => $time]);
    }

    /**
     * Triggers user side message box
     * @param $message string message to send
     * @param string $type ["info" Default |"error"|"success"|"warning"]
     */
    public function sendMessage($message, $type = 'info')
    {
        $this->dispatchBrowserEvent("show_message",
            ["type" => $type, "title" => "Info", "message" => $message]);
    }

    /**
     * @param string $fn_call Function name to be called
     * @param string $watcher Checks to see if the varaible is empty before pushing a confirm message to user
     * @param string $message Message to ask user on confirm
     * @throws \Exception CustomException [If non array is passed to be assessed]
     */
    public function confirm(string $fn_call, $watcher = null, string $message = "")
    {
        if ($watcher) {
            if (is_array($this->$watcher)) {
                if (!count($this->$watcher)) {
                    $this->sendMessage(__("common.nothing_has_been_selected"));
                    return;
                }
            } else {
                throw  new \Exception("You are asking me to assess a non array.");
            }
        }
        if (empty($message)) {
            $message = __("common.are_you_sure_abt_this_act");
        }
        if (method_exists($this, $fn_call)) {
            $this->dispatchBrowserEvent("confirm_for_be", ["fn_call" => $fn_call, "message" => $message]);
        }
    }
}

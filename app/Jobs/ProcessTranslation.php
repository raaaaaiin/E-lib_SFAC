<?php

namespace App\Jobs;


use App\Events\TranslationStatus;
use App\Models\LanguageTranslator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTranslation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $langTranslationObj;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        //
        $this->langTranslationObj = $obj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        event(new TranslationStatus(__("We have started working on translation  :P ...")));
        //$this->langTranslationObj->dispatchBrowserEvent("show_message", ["type" => "info", "title" => "Job Worker", "message" => ]);
        if ($this->langTranslationObj->sel_lang && $this->langTranslationObj->first && $this->langTranslationObj->last) {
            $values_to_trans = LanguageTranslator::with("main_translation")->where("lang", $this->langTranslationObj->sel_lang)->where("value", null)
                ->whereBetween("main_language_translator_id", [$this->langTranslationObj->first, $this->langTranslationObj->last])->get();
            $trans_text_arr = [];
            $count = 1;
            $done_count = 1;
            foreach ($values_to_trans as $obj) {
                if (!$obj->value) {
                    $trn_val = $this->langTranslationObj->translate([$obj->main_translation->value]);
                    array_push($trans_text_arr, $trn_val);
                    $item = LanguageTranslator::find($obj->id);
                    if ($item) {
                        $item->value = $trn_val[0];
                        $item->save();
                        $count++;
                        if ($count % 10 == 0) {
                            event(new TranslationStatus(__("Done so far : " . $count)));
                        }
                    }
                } else {
                    array_push($trans_text_arr, "");
                }
                $done_count++;
            }
            //$this->langTranslationObj->refresh_proxy_cnt();
            // $this->langTranslationObj->dispatchBrowserEvent("bulk_trans_catcher", ["translated_vals" => $trans_text_arr]);
            event(new TranslationStatus(__("We have completed your translation work.")));
        }

    }
}

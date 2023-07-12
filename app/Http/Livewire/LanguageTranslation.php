<?php

namespace App\Http\Livewire;

use App\Facades\Common;
use App\Facades\Util;
use App\Jobs\ProcessTranslation;
use App\Models\LanguageTranslator;
use App\Models\MainLanguageTranslator;
use App\Models\Setting;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LanguageTranslation extends Component
{
    public $sel_lang = 'en', $proxies, $count = 0, $sel_text_to_trans, $sel_id, $first, $last, $trans_item_per_page = 10;
    public $sv_sel_id, $sv_upd_val, $search_keyword;
    use CustomCommonLive;
    public $list_file = ["auth", "common", "course", "course_year", "error", "pagination", "passwords", "validation", "year", "laraupdater","commonv2"];
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["data_manager", "saveNewTranslation"];
    public $show_no_transalted = false;

    public function data_manager($datas)
    {
        if (isset($datas["text_to_trans"]) && isset($datas["id"])) {
            $this->sel_text_to_trans = $datas["text_to_trans"];
            $this->sel_id = $datas["id"];
        }
        if (isset($datas["first"]) && isset($datas["last"])) {
            $this->first = $datas["first"];
            $this->last = $datas["last"];
        }
        if (isset($datas["sv_sel_id"]) && isset($datas['sv_upd_val'])) {
            $this->sv_sel_id = $datas["sv_sel_id"];
            $this->sv_upd_val = $datas["sv_upd_val"];
        }
    }

    public function load_data()
    {
        $search_keyword = $this->search_keyword;
        $set_lang = $this->sel_lang;
        $datas = LanguageTranslator::whereHas("main_translation", function ($query) use ($search_keyword) {
            if (!empty($search_keyword)) {
                $query->where("key", "like", "%" . $search_keyword . "%")->orWhere("value", "like", "%" . $search_keyword . "%")->orWhere("file", "like", "%" . $search_keyword . "%");
            }
        })->where("lang", $set_lang);
        if ($this->show_no_transalted) {
            $datas = $datas->where(function ($query) {
                $query->where("value", null)->orWhere("value", "");
            });
        }
        $datas = $datas->paginate($this->trans_item_per_page < 15 ? $this->trans_item_per_page : 15);
        $this->sel_lang = $set_lang;
        return $datas;
    }


    public function refresh_translations()
    {
        foreach ($this->list_file as $mfile) {
            $combo = Lang::get($mfile);
            foreach ($combo as $key => $value) {
                if (!empty($value) && !empty($key)) {
                    $obj = MainLanguageTranslator::updateOrCreate(["type" => is_array($value) ? "array" : "string", "key" => $key,
                        "value" => is_array($value) ? json_encode($value) : $value, 'file' => $mfile]);
                    LanguageTranslator::updateOrCreate(["main_language_translator_id" => $obj->id],["main_language_translator_id" => $obj->id, "lang" => $this->sel_lang,
                        "value" => $this->sel_lang == "en" ? (is_array($value) ? json_encode($value) : $value) : ""]);
                }
            }
        }
        $this->sendMessage(__("common.trans_refresh"), "success");
    }


    public function mount()
    {
        //$this->sel_lang = Cookie::get("sel_lang") ?? $this->sel_lang;
        $this->trans_item_per_page = Common::getSiteSettings("trans_item_per_page");

    }

    public function flushToFile()
    {
        $datas = LanguageTranslator::with("main_translation")->where("lang", $this->sel_lang)->get();
        $base_path = base_path("resources/lang/");
        $main_lang_folder = $base_path . $this->sel_lang;
        if (!\File::exists($main_lang_folder)) {
            \File::makeDirectory($main_lang_folder);
        } else {
            \File::deleteDirectory($main_lang_folder);
            \File::makeDirectory($main_lang_folder);
        }
        $raw_data = [];
        foreach ($datas as $data) {
            $file_name = $data->main_translation->file;
            $value_to_write = Util::getIfNotEmpty($data->value) ?? $data->main_translation->value;
            $conv = iconv(mb_detect_encoding($value_to_write, mb_detect_order(), true), "UTF-8", $value_to_write);
            if ($data->main_translation->type == "string")
                $raw_data[$file_name][] = "'" . $data->main_translation->key . "'=>\"" . $conv . "\"," . PHP_EOL;
            else
                $raw_data[$file_name][] = "'" . $data->main_translation->key . "'=>" .
                    Str::of($conv)->replace(["{", "}", ":\"", ":["], ["[", "]", "=>\"", "=>["])->__toString()
                    . "," . PHP_EOL;
        }

        foreach ($this->list_file as $lfile) {
            if (isset($raw_data[$lfile])) {
                $fp = fopen($main_lang_folder . '/' . $lfile . '.php', 'a');
                fwrite($fp, '<?php return [');
                foreach ($raw_data[$lfile] as $fw) {
                    fwrite($fp, $fw);
                }
                fwrite($fp, '];?>');
                fclose($fp);
            }
        }
        $this->sendMessage(__("common.trans_flushed_to_file"), "success");
    }

    public function render()
    {
        $this->dispatchBrowserEvent("tooltip_refresh");
        return view('livewire.language-translation', ["items" => $this->load_data()]);
    }


    public function savePageListSetting()
    {
        if ($this->trans_item_per_page) {
            $status = Setting::updateOrCreate(["option_key" => "trans_item_per_page"], ["option_key" => "trans_item_per_page", "option_value" => $this->trans_item_per_page]);
            if ($status) {
                $this->sendMessage(__("common.setting_saved"), "success");
            }
        }
    }


    public
    function createNewTranslation()
    {
        if ($this->sel_lang) {
            $tmps = MainLanguageTranslator::all();
            $new_rows = [];
            foreach ($tmps as $tmp) {
                $wst = [];
                $wst["main_language_translator_id"] = $tmp->id;
                $wst["lang"] = $this->sel_lang;
                array_push($new_rows, $wst);
            }
            (new LanguageTranslator)->insertOrUpdate($new_rows);
            $this->sendMessage(__("common.new_trans_created"), "success");
        }
    }

    public
    function clearTrans()
    {
        LanguageTranslator::whereIn("lang", [$this->sel_lang])->delete();
        $this->sendMessage(__("common.all_trans_cleared"), "success");
    }

    public
    function saveNewTranslation()
    {
        if ($this->sv_upd_val && $this->sv_sel_id) {
            $lt_obj = LanguageTranslator::where("main_language_translator_id", $this->sv_sel_id)->where("lang", $this->sel_lang)->first();
            if ($lt_obj) {
                $lt_obj->value = $this->sv_upd_val;
                $lt_obj->save();
                $this->sendMessage(__("common.saved"), "success");
            }
        }
    }

    public function showNonTrans()
    {
        $this->show_no_transalted = !$this->show_no_transalted;
    }


}

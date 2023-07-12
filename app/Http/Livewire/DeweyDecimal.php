<?php

namespace App\Http\Livewire;

use App\Facades\Common;
use App\Facades\Util;
use \App\Models\DeweyDecimal as DeweyDecimalModel;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Facades\DB;

use App\Models\UserNotif;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DeweyDecimal extends Component
{
    use CustomCommonLive;

    public $cat_name;
    public $cat_parent = [];
    public $cat_sub_parent = [];
    public $dewey_no = 000.0000;
    public $shelf_no = 0; #not req
    public $sel_parent = 0; #not req
    public $sel_sub_parent = null; #not req
    public $sel_id;
    public $cat_image;
    public $bg_color = "#000000";
    public $txt_color = "#ffffff";
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $mode = "create";
    
    protected $listeners = ["deleteCat"];

    public function mount()
    {
        $this->refreshSelects();
        $this->refreshDeweyData();
    }

    public function refreshSelects()
    {
        $this->cat_parent = DeweyDecimalModel::where("parent", 0)->get();
        $this->cat_sub_parent = DeweyDecimalModel::where("parent", "<>", 0)->where("parent", "<>", null)->get();
    }
    public function clearCats(){

    }
    public function clearAllCategoryOfBook(){
        $sql_to_fire = ["update " . with(new \App\Models\Book())->getTable() . " SET category=NULL"];
        foreach ($sql_to_fire as $sql) {
            DB::unprepared($sql);
        }
    }
    public function clearClassTable()
    {
        $sql_to_fire = ["truncate table " . with(new DeweyDecimalModel())->getTable()];
        foreach ($sql_to_fire as $sql) {
            DB::unprepared($sql);
        }
        //$this->sendMessage(__("course.done"), "success");
    }

    public function loadBasicClass()
    {
        $this->clearClassTable();
        DB::unprepared(file_get_contents(storage_path("basic_class.sql")));
        $this->sendMessage(__("course.done"), "success");
    }

//    public function loadDewey()
//    {
//        DB::unprepared(file_get_contents(storage_path("dewey.sql")));
//        $this->sendMessage(__("course.done"), "success");
//    }

    public function refreshDeweyData()
    {
        return DeweyDecimalModel::where("parent", 0)->orderBy("dewey_no")->paginate(10);
    }

    public function render()
    {
        return view('livewire.dewey-decimal', ["all_dewey_data" => $this->refreshDeweyData()]);
    }

    public function deleteCat($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $obj = DeweyDecimalModel::find($id);
            if ($obj) {
//                if ($obj->parent == 0) {
//                    DeweyDecimalModel::whereIn("parent", [$obj->id])->delete();
//                }
                $notifinfo = [];
                array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Deleted Category" ,"Target" => $obj->cat_name,"Modifier" => ""));
                UserNotif::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Dewey","isread" => 0]);

                $obj->delete();
                $this->reset();
                $this->refreshDeweyData();
                $this->refreshSelects();
                $this->sendMessage(__("commonv2.cat_deleted"), "success");
            }
        } else {
            $this->sendMessage(__("common.id_missing"), "error");
        }
    }

    public function editCat($id)
    {
        if ($id) {
            $obj = DeweyDecimalModel::find($id);
            if ($obj) {
                $this->sel_id = $id;
                $this->cat_name = $obj->cat_name;
                $this->dewey_no = substr(Common::formatDeweyNo($obj->dewey_no), 0, -2);
                $this->shelf_no = $obj->shelf_no;
                $this->sel_parent = $obj->parent;
                $this->dispatchBrowserEvent("scroll_up");
            }
        }
    }

    public function saveCat()
    {

        if (!empty(trim($this->cat_name))) {
            if ($this->sel_parent) {
                $tmp = DeweyDecimalModel::find($this->sel_parent);
                if ($tmp) {
                    if ($tmp->parent != 0) {
                        $this->sendMessage(__("commonv2.only_single_level_is_supported"), "info");
                        return;
                    }
                }
            }
//            if ($this->shelf_no) {
//                $add_shelf = "0000.00" . strval(Common::formatShelfNo($this->shelf_no));
//                $this->dewey_no = $this->dewey_no + floatval($add_shelf);
//            }
//            if (Common::getSiteSettings("enable_basic_classification")) {
//                if (!empty($this->sel_sub_parent) && empty($this->sel_parent)) {
//                    $this->sendMessage(__("commonv2.pl_msg_basic_class"), "info");
//                    return;
//                }
//                $this->dewey_no = 000.00;
//            }
            $image = null;
            if ($this->cat_image) {
                $image = $this->cat_image->storePublicly('', 'custom');
            }

//            if ($this->sel_sub_parent) {
//                $this->sel_parent = null;
//            }
//            if (empty($this->sel_sub_parent)) {
//                $this->sel_sub_parent = null;
//            }

            $tmp = DeweyDecimalModel::updateOrCreate(["id" => $this->sel_id],
                ["cat_name" => $this->cat_name, "shelf_no" => $this->shelf_no,
                    "parent" => $this->sel_parent, "image" => $image, "bg_color" => $this->bg_color, "txt_color" => $this->txt_color]);
        $notifinfo = [];
         array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Posted New Category" ,"Target" => $this->cat_name,"Modifier" => ""));
         UserNotif::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Dewey","isread" => 0]);

            if ($tmp) {
                DeweyDecimalModel::updateOrCreate(["cat_name" => "Unassigned", "parent" => $tmp->id]);
                $this->cat_name = "";
                #$this->sel_id = "";
                #$this->refreshDeweyData();
                $this->refreshSelects();
                $this->sendMessage(__("common.cat_saved"), "success");

            } else {
                $this->sendMessage(__("common.some_error_occured"), "error");
            }
        } else {
            $this->sendMessage(__("commonv2.cat_name_missing"), "");
        }
    }
}

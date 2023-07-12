<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\UserMeta;
use App\Models\UserNotif;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use MongoDB\Driver\Session;


class Slider extends Component
{
    use WithFileUploads;
    public $mode = "create";
    public $group = "";
    public $slider_image;
    public $header = "";
    public $sub_header = "";
    public $photo_link;
    public $edit_id;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["deleteSlider"];

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.slider', ["sliders" => \App\Models\Slider::paginate(10)]);
    }

    public function editSlider($id)
    {
        $this->mode = "edit";
        $slider_obj = \App\Models\Slider::find($id);
        if ($slider_obj) {
            $this->edit_id = $id;
            $this->group = $slider_obj->group;
            $this->photo_link = $slider_obj->image;
            $this->header = $slider_obj->header;
            $this->sub_header = $slider_obj->sub_header;
        }
    }

    public function saveSlider()
    {
        session()->flash("form_slider", true);
        $val_fields = [
            "group" => "required",
        ];
        $val_fields_error_msg = ["group.required" => __("common.grp_name_req")];
        if ($this->mode == "create") {
            $val_fields["slider_image"] = "required|max:1024|mimes:jpg,jpeg,png";
            $val_fields_error_msg["slider_image.mimes"] = __("common.only_image");
            $val_fields_error_msg["slider_image.required"] = __("common.image_req");
            $val_fields_error_msg["slider_image.max"] = __("common.file_size_exceed");

        }
        $this->validate($val_fields, $val_fields_error_msg);
        $data_to_ins = ["group" => $this->group,
            "header" => $this->header, "sub_header" => $this->sub_header];

        if ($this->slider_image) {
            $path = $this->slider_image->storePublicly('', 'custom');
            $data_to_ins["image"] = $path;
        }

        \App\Models\Slider::updateOrCreate(["id" => $this->edit_id], $data_to_ins);
        $notifinfo = [];
                        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Created new Carousel " ,"Target" => "#".$this->edit_id,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Carousel","isread" => 0]);
        $this->reset();
        session()->flash("alert-success", __("common.slider_status",
            ["status" => __($this->mode == "edit" ? "common.updated" : "common.created")]));
    }

    public function deleteSlider($datas)
    {
        session()->flash("form_slider", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $slider_obj = \App\Models\Slider::find($id);
            if ($slider_obj) {
                Storage::disk("custom")->delete($slider_obj->image);
                $slider_obj->delete();
                $this->reset();
                session()->flash("alert-success", __("common.slider_del"));
                $notifinfo = [];
                        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Deleted Carousel " ,"Target" => "#".$id,"Modifier" => ""));
                        UserNotif::Create(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Carousel","isread" => 0]);
            }
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }
}

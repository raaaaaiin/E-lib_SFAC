<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Tag;
use App\Traits\CustomCommonLive;
use Livewire\Component;
use Livewire\WithPagination;

class TagMng extends Component
{
    public $tag_name = "";
    public $mode = "create";
    public $selected_id;
    use CustomCommonLive;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_keyword;
    protected $listeners = ["deleteTag"];

    public function load_data()
    {
        if (!empty($this->search_keyword)) {
            return Tag::with("books")->where("name", "like", "%" . $this->search_keyword . "%")
                ->orderBy("id", "desc")->paginate(10);
        }
        return Tag::with("books")->orderBy("id", "desc")->paginate(10);
    }
    public function clearSearch()
    {
        $this->search_keyword = "";
    }

    public function render()
    {
        return view('livewire.tag-mng', ["items" => $this->load_data()]);
    }

    public function saveTag()
    {
        if ($this->tag_name) {
            $tmp = Tag::updateOrCreate(["id" => $this->selected_id], ["name" => $this->tag_name]);
            if ($tmp) {
                $this->sendMessage(__("common.saved"), "success");
            } else {
                $this->sendMessage(__("commonv2.nothing_saved"), "info");
            }
        }
    }

    public function editTag($id)
    {
        if ($id) {
            $this->mode = "edit";
            $author = \App\Models\Tag::find($id);
            if ($author) {
                $this->selected_id = $id;
                $this->tag_name = $author->name;
            }
        }

    }

    public function deleteTag($datas)
    {
        session()->flash("form_author", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $tag_obj = \App\Models\Tag::find($id);
            if ($tag_obj) {
                $tag_obj->delete();
                //$this->subscribers = \App\Subscriber::all();
                $this->reset();
                session()->flash("alert-success", __("commonv2.tag_deleted"));
            }
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }
}

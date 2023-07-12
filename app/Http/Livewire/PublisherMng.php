<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\Author;
use App\Models\Publisher;
use App\Traits\CustomCommonLive;
use Livewire\Component;
use Livewire\WithPagination;

class PublisherMng extends Component
{
    public $publisher_name = "";
    public $mode = "create";
    public $selected_id;
    public $search_keyword;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    use CustomCommonLive;

    protected $listeners = ["deletePublisher"];

    public function render()
    {
        return view('livewire.publisher-mng', ["items" => $this->load_data()]);
    }

    public function clearSearch()
    {
        $this->search_keyword = "";
    }

    public function load_data()
    {
        if (!empty($this->search_keyword)) {
            return Publisher::with("books")->where("name", "like", "%" . $this->search_keyword . "%")
                ->orderBy("id", "desc")->paginate(10);
        }
        return Publisher::with("books")->orderBy("id", "desc")->paginate(10);
    }


    public function savePublisher()
    {
        if ($this->publisher_name) {
            $tmp = Publisher::updateOrCreate(["id" => $this->selected_id], ["name" => $this->publisher_name]);
            if ($tmp) {
                $this->sendMessage(__("common.saved"), "success");
            } else {
                $this->sendMessage(__("commonv2.nothing_saved"), "info");
            }
        }
    }

    public function editPublisher($id)
    {
        if ($id) {
            $this->mode = "edit";
            $author = \App\Models\Publisher::find($id);
            if ($author) {
                $this->selected_id = $id;
                $this->publisher_name = $author->name;
            }
        }

    }

    public function deletePublisher($datas)
    {
        session()->flash("form_publisher", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $publisher_obj = \App\Models\Publisher::find($id);
            if ($publisher_obj) {
                $publisher_obj->delete();
                //$this->subscribers = \App\Subscriber::all();
                $this->reset();
                session()->flash("alert-success", __("commonv2.publisher_deleted"));
            }
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }
}

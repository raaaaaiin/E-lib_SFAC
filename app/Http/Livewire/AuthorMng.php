<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\Author;
use App\Traits\CustomCommonLive;
use Livewire\Component;
use Livewire\WithPagination;

class AuthorMng extends Component
{
    public $author_name = "";
    public $mode = "create";
    public $selected_id;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    use CustomCommonLive;

    public $search_keyword = "";
    protected $listeners = ["deleteAuthor"];

    public function load_data()
    {
        if (!empty($this->search_keyword)) {
            return Author::with("books")->where("name", "like", "%" . $this->search_keyword . "%")
                ->orderBy("id", "desc")->paginate(10);
        }
        return Author::with("books")->orderBy("id", "desc")->paginate(10);
    }

    public function clearSearch()
    {
        $this->search_keyword = "";
    }

    public function render()
    {
        return view('livewire.author-mng', ["items" => $this->load_data()]);
    }

    public function saveAuthor()
    {
        if ($this->author_name) {
            $tmp = Author::updateOrCreate(["id" => $this->selected_id], ["name" => $this->author_name]);
            if ($tmp) {
                $this->sendMessage(__("common.saved"), "success");
                $this->search_keyword = "";
                $this->author_name = "";
            } else {
                $this->sendMessage(__("commonv2.nothing_saved"), "info");
            }
        }
    }

    public function editAuthor($id)
    {
        if ($id) {
            $this->mode = "edit";
            $author = \App\Models\Author::find($id);
            if ($author) {
                $this->selected_id = $id;
                $this->author_name = $author->name;
            }
        }

    }

    public function deleteAuthor($datas)
    {
        session()->flash("form_author", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $author_obj = \App\Models\Author::find($id);
            if ($author_obj) {
                $author_obj->delete();
                //$this->subscribers = \App\Subscriber::all();
                $this->reset();
                session()->flash("alert-success", __("commonv2.author_deleted"));
            }
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }
}

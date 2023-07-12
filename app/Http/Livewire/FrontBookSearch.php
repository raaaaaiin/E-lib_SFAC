<?php

namespace App\Http\Livewire;

use App\Facades\Common;
use App\Facades\Util;
use App\Traits\CustomCommonLive;
use Livewire\Component;

class FrontBookSearch extends Component
{
    public $parentCats = [];
    public $sel_main_cat = "";
    public $sel_sub_cat = "";
    protected $listeners = ["data_manager"];
    public $search_keyword;
    public $matched_books = [];
    public $searchBtn = false;
    use CustomCommonLive;

    public function data_manager($datas)
    {
        if (isset($datas["sel_main_cat"])) {
            $this->sel_main_cat = $datas["sel_main_cat"];
        }
        if (isset($datas["sel_sub_cat"])) {
            $this->sel_sub_cat = $datas["sel_sub_cat"];
        }
        $this->clearKeyword();
    }

//    public function updatedSearchKeyword()
//    {
//        if (empty($this->search_keyword)) {
//            $this->matched_books = [];
//        }
//    }

    public function updatedSearchKeyword()
    {

        $search_keyword = $this->search_keyword;
        if (empty($this->search_keyword)) {
            $this->matched_books = [];
        } else {
            if (strlen($search_keyword) >= 3) {
                $this->matched_books = \App\Models\Book::whereHas("authors", function ($query) use ($search_keyword) {
                    $query->where("name", "like", "%" . $search_keyword . "%");
                })->orwhereHas("publishers", function ($query) use ($search_keyword) {
                    $query->where("name", "like", "%" . $search_keyword . "%");
                })->orwhereHas("tags", function ($query) use ($search_keyword) {
                    $query->where("name", "like", "%" . $search_keyword . "%");
                })->orwhereHas("category", function ($query) use ($search_keyword) {
                    $query->where("cat_name", "like", "%" . $search_keyword . "%")->orWhere("dewey_no", "like", "%" . $search_keyword . "%");
                })->orwhere(function ($query) use ($search_keyword) {
                    $query->where("title", "like", "%" . $search_keyword . "%")
                        ->orwhere("desc", "like", "%" . $search_keyword . "%");
                })->get();
            }
        }
        if (!empty($this->search_keyword)) {
            $matched_book_Cnt = count($this->matched_books);
            if ($matched_book_Cnt) {
                session()->flash("books-found-searching", __("commonv2.found_book_matching_ur_criteria", ["count" => $matched_book_Cnt]));
            }
        }
    }

    public function mount()
    {
        $this->parentCats = Common::getAllParentCats();
        if ($this->search_keyword) {
            $this->updatedSearchKeyword();
        }
    }

    public function clearKeyword()
    {
        $this->search_keyword = "";
        $this->dispatchBrowserEvent("clear_query_string");
    }

    public function render()
    {

        if ($this->sel_main_cat && $this->sel_sub_cat && empty($this->search_keyword)) {
            $sub_cat_count = \App\Models\Book::where("category", $this->sel_sub_cat)->count();
            if ($sub_cat_count) {
                session()->flash("books-found", __("commonv2.book_frn_this_cat", ["count" => $sub_cat_count]));
            }
        }
        return view('livewire.front-book-search');
    }
}

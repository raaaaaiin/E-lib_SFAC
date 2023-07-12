<?php

namespace App\Http\Livewire;

use App\Custom\BookCallBacks;
use App\Facades\Util;
use App\Models\Borrowed;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SubBook extends Component
{

    public $search_keyword;
    use WithPagination, CustomCommonLive;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["deleteMainBook", "data_manager", "saveCategory", "toggleActiveMainBook"];
    public $cat_detail;
    public $show_inactive = false;
    public $enable_bulk_operation = false;
    public $sel_parent_cat;
    public $sel_sub_cat;
    public $sel_sb_id_bulk = [];

    /**
     * @return bool
     */
    public function isEnableBulkOperation(): bool
    {
        return $this->enable_bulk_operation;
    }

    public function data_manager($datas)
    {
        if (isset($datas["cat_detail"])) {
            $this->cat_detail = $datas["cat_detail"];
        }
    }

    public function load_data()
    {
        $search_keyword = $this->search_keyword;
        $inactive_status = $this->show_inactive;
        $books = \App\Models\Book::whereHas("sub_books", function ($query) use ($search_keyword, $inactive_status) {
            if (!empty($search_keyword)) {
                if ($inactive_status) {
                    $query->where("active", 0);
                } else {
                    $query->where("active", 1);
                }
                $query->Where(function ($query) use ($search_keyword) {
                    $query->where("sub_book_id", "like", "%" . $search_keyword . "%")->orWhere("remark", "like", "%" . $search_keyword . "%");
                });
            } else {
                if ($inactive_status) {
                    $query->where("active", 0);
                } else {
                    $query->where("active", 1);
                }
            }
        });
        if ($search_keyword) {
            $books = $books->where("active", 1)->orwhere(function ($query) use ($search_keyword) {
                $query->where("isbn_10", "like", "%" . $search_keyword . "%")
                    ->orWhere("isbn_13", "like", "%" . $search_keyword . "%")
                    ->orWhere("title", "like", "%" . $search_keyword . "%")
                    ->orWhere("desc", "like", "%" . $search_keyword . "%")
                    ->orWhereHas("category", function ($query) use ($search_keyword) {
                        $query->where("cat_name", "like", "%" . $search_keyword . "%")->orWhere("dewey_no", "like", "%" . $search_keyword . "%");
                    })->orwhereHas("authors", function ($query) use ($search_keyword) {
                        $query->where("name", "like", "%" . $search_keyword . "%");
                    })->orwhereHas("publishers", function ($query) use ($search_keyword) {
                        $query->where("name", "like", "%" . $search_keyword . "%");
                    })->orwhereHas("tags", function ($query) use ($search_keyword) {
                        $query->where("name", "like", "%" . $search_keyword . "%");
                    });

            });
        }
        if ($inactive_status) {
            $books = $books->where("active", 0);
        }
        if ($search_keyword) {
            $this->resetPage();
        }
        $books = $books->orderBy("id", "desc")->paginate(10);
        return $books;
    }

    public function bulkSaveCategory()
    {
        foreach ($this->sel_sb_id_bulk as $b_id) {
            $item = \App\Models\Book::find($b_id);
            if ($item) {
                $item->category = $this->sel_sub_cat;
                $item->save();
            }
        }
        $this->sel_sb_id_bulk = [];
        $this->sendMessage(__("commonv2.done"), "success");
    }

    public function saveCategory($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $book_obj = \App\Models\Book::find($id);
            if ($book_obj) {
                $book_obj->category = Str::lower($this->cat_detail);
                $book_obj->save();
                $this->sendMessage(__("common.cat_saved"), "success");
            }
        } else {
            $this->sendMessage(__("common.id_missing"), "error");
        }
    }

    public function render()
    {
        return view('livewire.sub-book', ["items" => $this->load_data()]);
    }

    public function deleteMainBook($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $book_id = \App\Models\Book::find($id);
            if ($book_id) {
                Util::smartDelete("cover_img", public_path("uploads"), [$book_id]);
                Util::smartDelete("custom_file", public_path("uploads"), [$book_id]);
                list($book_id) = (new BookCallBacks())->beforeMainBookDelete($book_id);
                \Artisan::call("backup:run"); // Creates a backup
                \App\Models\SubBook::whereIn("book_id", [$book_id->id])->delete();
                \App\Models\Newsfeed::whereIn("book_id", [$book_id->unique_id])->delete();
                Borrowed::whereIn("book_id", [$book_id->id])->delete();
                $book_id->delete();
                (new BookCallBacks())->afterMainBookDelete();
                $this->sendMessage(__("common.book_has_been_deleted"), "success");
            }
        } else {
            $this->sendMessage(__("common.id_missing"), "info");
        }
        $this->refresh_js();
    }

    public function toggleActiveMainBook($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $book_id = \App\Models\Book::find($id);
            if ($book_id) {
                $book_id->active = !$book_id->active;
                \App\Models\SubBook::where("book_id", $book_id->id)->update(["active" => $book_id->active]);
                $book_id->save();
                if (!$book_id->active) {
                    $this->sendMessage(__("common.book_has_been_deactivated"), "success");
                } else {
                    $this->sendMessage(__("common.book_has_been_activated"), "success");
                }
            }
        } else {
            $this->sendMessage(__("common.id_missing"), "info");
        }
        $this->refresh_js();
    }

    public function refresh_js()
    {
        $this->dispatchBrowserEvent("tooltip_refresh");

    }
}

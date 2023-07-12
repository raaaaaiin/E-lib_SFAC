<?php

namespace App\Http\Livewire;

use App\Custom\BookCallBacks;
use App\Events\BeforeMainBookInsert;
use App\Facades\Common;
use App\Facades\Util;
use App\Models\Author;
use App\Models\Borrowed;
use App\Models\Publisher;
use App\Models\SubBook;
use App\Models\BookMeta;
use App\Models\UserNotif;
use App\Models\Tag;
use App\Models\Newsfeed;
use App\Models\User;
use App\Traits\CustomCommonLive;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Book extends Component
{
    use CustomCommonLive;

    public $book_id;
    public $isbn;
    public $isbn_10;
    public $isbn_13;
    public $author_name = "N/A";
    public $unique_id;
    public $title;
    public $category = "Others";
    public $dewey;
    public $circulation;
    public $edition = "";
    public $publicationyear;
    public $authorno;
    public $publisher = "N/A";
    public $preview_url;
    public $google_img;
    public $custom_img;
    public $cover_img = "";
    public $desc;
    public $custom_file;
    public $mode = "create";
    public $book_qnt = 0;
    public $sub_books;
    public $calling_from = "main_book";
    public $books_collections = [];
    public $books_acquisition = [];
    public $books_existing_collections = [];
    public $books_existing_acquisition = [];
    public $submit_id = true;
    public $sel_cat = "";
    public $publishloc = "";
    public $sel_sub_cat = "";
    public $sel_authors = [];
    public $sel_publishers = [];
    public $sel_tags = [];
    public $sel_medtypes = [];
    public $show_custom_img = "https://via.placeholder.com/120x120";
    use WithFileUploads;

    public $todo = "save";
    use WithPagination;

    public $sub_cats = [];
    public $sel_sub_cats = "";
    protected $paginationTheme = 'bootstrap';
    public $edit_id;
    public $via = "google";
    protected $listeners = ["addSubBooksQnty", "removeSubBooksQnty", "data_manager", "saveBook", "checkIfSubBookIdExist", "deleteSubBook"];
    public $authorData = [];
    public $publisherData = [];
    public $tagData = [];
    public $MedtypeData = [];

    public function updatedSelCat()
    {
        $this->sub_cats = \App\Models\DeweyDecimal::where("parent", $this->sel_cat)->get();

    }

    public function data_manager($datas)
    {
        if (isset($datas["publishers"])) {
            $this->sel_publishers = $datas["publishers"];
        }
        if (isset($datas["authors"])) {
            $this->sel_authors = $datas["authors"];
        }
        if (isset($datas["tags"])) {
            $this->sel_tags = $datas["tags"];
        }
        if (isset($datas["medtypes"])) {
            $this->sel_medtypes = $datas["medtypes"];
        }
        if (isset($datas["todo"])) {
            $this->todo = $datas["todo"];
        }
        if (isset($datas["desc"])) {
            $this->desc = $datas["desc"];
        }
        if (isset($datas["desc"])) {
            $this->desc = $datas["desc"];
        }
        if (isset($datas["items"])) {
            $last_element = end($datas["items"]);
            $data_in_array = array_reduce($datas["items"], function ($items, $data) use ($last_element) {
                $i = isset($items["i"]) ? $items["i"] : 0;
                $temp = isset($items["loop"]) ? $items["loop"] : [];
                $res = isset($items["holder"]) ? $items["holder"] : [];
                if (!Str::contains($data["name"], "[" . $i . "]")) {
                    $res[$i] = $temp;
                    $temp = [];
                    $i = $i + 1;
                }
                if (Str::contains($data["name"], "book_id")) {
                    $temp["book_id"] = $data["value"];
                }
                if (Str::contains($data["name"], "book_condition")) {
                    $temp["book_condition"] = $data["value"];
                }if (Str::contains($data["name"], "book_acquisition")) {
                    $temp["book_acquisition"] = $data["value"];
                }
                if (Str::contains($data["name"], "book_price")) {
                    $temp["book_price"] = $data["value"];
                }
                if (Str::contains($data["name"], "book_status")) {
                    $temp["book_status"] = $data["value"];
                }
                if (Str::contains($data["name"], "book_remark")) {
                    $temp["book_remark"] = $data["value"];
                }
                if ($data == $last_element) {
                    $res[$i] = $temp;
                    return $res;
                }
                return ["loop" => $temp, "i" => $i, "holder" => $res];
            });
            $this->books_collections = $data_in_array;
        }
    }


    public function addSubBooksQnty()
    {
        if (!$this->title) {
            $this->sendMessage(__("common.kindly_fill_the_title_before_continue"), "error");
            return;
        }
        $this->book_qnt = $this->book_qnt + 1;
    }

    public function mount()
    {
        $this->reloadAuthorData();
        $this->reloadPublisherData();
        $this->reloadTagData();
        $this->reloadMedtypesData();
        if ($this->edit_id) {
            $temp = \App\Models\Book::find($this->edit_id);
            if ($temp) {
                $this->isbn = !empty($temp->isbn_10) ? $temp->isbn_10 : (!empty($temp->isbn_13) ? $temp->isbn_13 : $temp->unique_id);
                $this->mode = "edit";
            }
            $this->searchBookInfo();
        }
    }

    public function refresh_js()
    {
        $this->dispatchBrowserEvent("toogle_refresh");
        $this->dispatchBrowserEvent("tooltip_refresh");
        $this->dispatchBrowserEvent("select_2_refresh");
        $this->dispatchBrowserEvent("relink_js");

    }

    public function removeSubBooksQnty()
    {
        if ($this->book_qnt > count($this->books_existing_collections)) {
            $this->book_qnt = $this->book_qnt - 1;
        }
    }


    public function render()
    {
        $this->refresh_js();
        return view('livewire.book');
    }

    public function generateRandomId()
    {

    }

    public function clearCustomUploadControl()
    {
        $this->custom_file = "";
    }

    public function saveBook()
    {
        $this->validate([
            "title" => "required",
            "custom_img" => "nullable|mimes:jpg,png,jpeg",
            "custom_file" => "nullable|mimes:pdf",
            "sel_cat" => "required",
            "sel_sub_cat" => "required"
        ], ["sel_cat.required" => __("commonv2.fc_sel_cat"), "sel_sub_cat.required" => __("commonv2.fc_sel_sub_cat")]);
        if (!$this->book_qnt) {
            $this->sendMessage(__("commonv2.you_hv_forgot_to_add_book"), "info");
            return;
        }
        if (!empty($this->isbn)) {
            if ($this->isbn && strlen($this->isbn) >= 13) {
                $this->isbn_13 = $this->isbn;
            } else {
                $this->isbn_10 = $this->isbn;
            }
        }
        $img_link = "";
        $file_link = "";
        if ($this->custom_img && $this->custom_img instanceof TemporaryUploadedFile) {
            $img_link = $this->custom_img->storePublicly('', 'custom');
            $this->cover_img = asset("uploads/" . $img_link,false);
        }

        if ($this->custom_file && $this->custom_file instanceof TemporaryUploadedFile) {
            $file_link = $this->custom_file->storePublicly('', 'custom');
        }
        $this->unique_id = Util::getIfNotEmpty($this->unique_id) ?? 'R-' . Util::generateRandomString(5);
        if ($this->via == "openlib" || $this->via == "amazon") {
            if (Util::isUrl($this->cover_img)) {
                $tp = explode("/", $this->cover_img);
                $img_link = end($tp);
            }
        }
        if ($this->via == "google" && !Util::isInternalUrl($this->cover_img)) {
            $tp = Util::saveFileFromUrl($this->cover_img, ".jpg");
            $this->cover_img = asset("uploads/" . $tp,false);
            if (Util::isUrl($this->cover_img)) {
                $tp = explode("/", $this->cover_img);
                $img_link = end($tp);
            }
        }
        if (Util::isUrl($this->cover_img) && !Util::isInternalUrl($this->cover_img)) {
            $tp = explode("/", $this->cover_img);
            $img_link = end($tp);
        }
         $tp = explode("/", $this->cover_img);
         $img_link = end($tp);
        $to_put = ["unique_id" => $this->unique_id, "isbn_10" => $this->isbn_10, "isbn_13" => $this->isbn_13,
            "title" => $this->title, "desc" => $this->desc, "category" =>
                $this->sel_sub_cat, "preview_url" => $this->preview_url,"cover_img" => $img_link,];
        
        $this->reloadAuthorData(true);
        
            $to_put["custom_file"] = $file_link;
            $to_put["authornumber"] =  $this->authorno;
            $to_put["dewey"] =  $this->dewey;
            $to_put["published_date"] =  $this->publicationyear;
            $to_put["circulation"] =  $this->circulation;
            $to_put["edition"] = $this->edition;
            $to_put["author"] =  $this->authorData[$this->sel_authors[0]];
            $to_put["publisher"] =  $this->publisherData[$this->sel_publishers[0]];
            $to_put["published_loc"] =  $this->publishloc;
        
        // Note if you have any new field added you can use the callback to put data into the respective array
        // This way you can still use the update feature provided by us without you loosing your made changes.
        list($to_put) = (new BookCallBacks)->beforeMainBookSaved($to_put);
        $book_main_id = \App\Models\Book::updateOrCreate(["unique_id" => $this->unique_id], $to_put
        );
        $book_main_id->authors()->timestamps = true;
        $book_main_id->publishers()->timestamps = true;
        $book_main_id->tags()->timestamps = true;
        $book_main_id->medtypes()->timestamps = true;
        $book_main_id->authors()->sync(Util::smartEnteriesCreator($this->sel_authors, "name", Author::class));
        $book_main_id->publishers()->sync(Util::smartEnteriesCreator($this->sel_publishers, "name", Publisher::class));
        $book_main_id->tags()->sync(Util::smartEnteriesCreator($this->sel_tags, "name", Tag::class));
        $book_main_id->medtypes()->sync(Util::smartEnteriesCreator($this->sel_medtypes, "name", Medtype::class));
        BookMeta::updateOrCreate(["meta_key" => "views", "unique_id" => $this->unique_id,"meta_value" => 0]);
         $notifinfo = [];
         array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Posted New Book" ,"Target" => $this->unique_id,"Modifier" => "Check this out!"));
         UserNotif::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "NewBook","isread" => 0]);

        $book_main_id->save();
        $newsfeed = new Newsfeed;
        $newsfeed->views = 1;
        $newsfeed->post_id = (new User)->get_current_id();
        $newsfeed->book_id = $this->unique_id;
        $newsfeed->title = $this->title;
        $newsfeed->description =  $this->desc;
        $newsfeed->category = $this->sel_sub_cat;
        $newsfeed->save();
        $books_collections = $this->books_collections;
        list($book_main_id, $books_collections) = (new BookCallBacks)->afterMainBookSaved($book_main_id, $books_collections);
        if ($book_main_id) {
            if ($books_collections) {
                foreach ($books_collections as $book) {
                    if ($book_main_id->id) {
                        $lst_id = \App\Models\SubBook::updateOrCreate(["sub_book_id" => Str::lower($book["book_id"]), "book_id" => $book_main_id->id],
                            ["sub_book_id" => Str::lower($book["book_id"]), "remark" => $book["book_remark"],
                                "price" => !empty($book["book_price"]) ? $book["book_price"] : 0, "active" => isset($book["book_status"]) ? 1 : 0
                                , "condition" => $book["book_condition"],"acquisition" =>$book["book_acquisition"]]);
                    }
                }
            }
            $this->searchBookInfo();
            $this->sendMessage(__("common.book_details_has_been_saved"), "success");
            if ($this->todo == "clearForm") {
                $this->dispatchBrowserEvent("refresh_page");
            }
        }

    }

    public function printBarcode($book_id)
    {
        $sb_ids = \App\Models\SubBook::whereIn("book_id", [$book_id])->get()->pluck("sub_book_id")->toArray();
        if (is_countable($sb_ids) && count($sb_ids)) {
            return redirect(route("printing_barcode", ["sbook_ids" => implode(",", $sb_ids)]));
        } else {
            $this->sendMessage(__("commonv2.nothing_can_be_found_here"), "info");
        }
    }

    public function reloadAuthorData($new = false)
    {
        if ($new) {
            $this->authorData = Author::all()->pluck("name", "id");
            $this->dispatchBrowserEvent("select_2_refresh");
        } else {
            $this->authorData = Common::getAllAuthorsInArray();
        }
    }

    public function reloadPublisherData($new = false)
    {
        if ($new) {
            $this->publisherData = Publisher::all()->pluck("name", "id");
            $this->dispatchBrowserEvent("select_2_refresh");
        } else {
            $this->publisherData = Common::getAllPublishersInArray();
        }
    }

    public function reloadTagData($new = false)
    {
        if ($new) {
            $this->tagData = Tag::all()->pluck("name", "id");
            $this->dispatchBrowserEvent("select_2_refresh");
        } else {
            $this->tagData = Common::getTagsInArray();
        }
    }
    public function reloadMedtypesData($new = false){
         if ($new) {
            $this->MedtypeData = Medtype::all()->pluck("name", "id");
            $this->dispatchBrowserEvent("select_2_refresh");
        } else {
            $this->MedtypeData = Common::getMedtypesInArray();
        }
    }

    public function clearForm()
    {
        $this->reset();
    }

    public function searchBookInfo()
    {
        //
        $this->books_existing_collections = [];
        $cleanedISBN = str_replace("-", "", $this->isbn);
        if (empty($cleanedISBN)) {
            $this->sendMessage(__("common.isbn_missing"), "error");
            return;
        }
        $temp = \App\Models\Book::with(["sub_books" => function ($query) {
            $query->orderBy("active", "desc");
        }]);
        if (Str::contains($this->isbn, "R-")) {
            $temp = $temp->Where("unique_id", $this->isbn);
        } else {
            $temp = $temp->where("isbn_10", $cleanedISBN)->orWhere("isbn_13", $cleanedISBN);
        }

        $temp = $temp->first();
        if ($temp) {

            $this->sel_authors = $temp->authors()->pluck("authors.id")->toArray();
            $this->unique_id = $temp->unique_id;
            $this->title = $temp->title;
            $this->sel_publishers = $temp->publishers()->pluck("publishers.id")->toArray();
            $this->sel_tags = $temp->tags()->pluck("tags.id")->toArray();
            $this->sel_medtypes = $temp->medtypes()->pluck("medtypes.id")->toArray();
            $this->isbn_10 = $temp->isbn_10;
            $this->isbn_13 = $temp->isbn_13;
            $this->desc = $temp->desc;
            $this->edition = $temp->edition;
            $this->publishloc = $temp->published_loc;
            $this->dewey = $temp->dewey;
            $this->circulation = $temp->circulation;
            $this->publicationyear = $temp->published_date;
            $this->authorno = $temp->authornumber;

            $this->google_img = $temp->google_img;
            $tp = \App\Models\DeweyDecimal::find($temp->category);
            if ($tp) {
                $this->sel_cat = $tp->parent;
                $this->updatedSelCat();
                $this->sel_sub_cat = $temp->category;
            }
            $this->preview_url = $temp->preview_url;
            $this->book_id = $temp->id;
            $this->cover_img = $temp->cover_img();
            $this->book_qnt = $temp->sub_books->count();
            if ($temp->sub_books->count()) {
                $this->books_existing_collections = $temp->sub_books->toArray();
                $this->mode = "edit";
            }
            $this->sendDescUpdate();
            return;
        }
        $found = false;
        if (!Common::getSiteSettings("enable_only_amazon_fetching")) {
            $datas = Util::curlPost("https://www.googleapis.com/books/v1/volumes?q=isbn:" .
                $cleanedISBN, "", ["Content-Type:application/json"], "GET", true);
            if (!empty($datas)) {
                $datas = json_decode($datas, true);
                if (isset($datas["totalItems"]) && $datas["totalItems"] != 1) {
                    $datas = Util::curlPost("https://openlibrary.org/api/books?bibkeys=" .
                        $cleanedISBN . "&format=json", "", ["Content-Type:application/json"], "GET", true);
                    $datas = json_decode($datas, true);
                    $datas = isset($datas[key(Util::getIfNotEmpty($datas) ?? [])]) ? $datas[key($datas)] : "";

                }
                // Analysis the google api
                if (isset($datas["items"])) {
                    try {
                        $book = Common::analyseBookDetails($datas);
                        $this->author_name = $book["author_name"];
                        $this->unique_id = $book["unique_id"];
                        $this->title = $book["title"];
                        $this->publisher = $book['publisher'];
                        $this->isbn_10 = $book['isbn_10'];
                        $this->isbn_13 = $book['isbn_13'];
                        $this->desc = $book["desc"];
                        $this->publicationyear = date("Y",strtotime($book["publishedDate"]));
                        $this->cover_img = $book["cover_img"];
                        $this->preview_url = $book["preview_url"];
                        $this->via = "google";

                        $author_ids = [];
                        if (isset($book['author_name']) && !empty($book["author_name"])) {
                            $tmp = explode(",", $book["author_name"]);
                            foreach ($tmp as $t) {
                                $author_obj = Author::updateOrCreate(["name" => $t]);
                                $author_ids[] = $author_obj->id;
                            }
                        }
                        $this->reloadAuthorData(true);
                        $this->sel_authors = $author_ids;
                        $publisher_ids = [];
                        if (isset($book['publisher']) && !empty($book["publisher"])) {
                            $tmp = explode(",", $book["publisher"]);
                            foreach ($tmp as $t) {
                                $publisher_obj = Publisher::updateOrCreate(["name" => $t]);
                                $publisher_ids[] = $publisher_obj->id;
                            }
                        }
                        $this->reloadPublisherData(true);
                        $this->sel_publishers = $publisher_ids;
                        $this->dispatchBrowserEvent("refresh_selects",
                            ["sel_publishers" => $this->sel_publishers, 'sel_authors' => $this->sel_authors]);
                        $found = true;

                    } catch (\Exception $e) {
                        $this->sendMessage($e->getMessage(), "error");
                    }
                }
                // Analysis the open library api
                if (isset($datas["info_url"])) {
                    try {
                        $book = Common::analyseBookDetails($datas);
                        $this->title = Util::getIfNotEmpty($book["title"]) ?? "";
                        $this->isbn_10 = Util::getIfNotEmpty($book['isbn_10']) ?? "";
                        $this->isbn_13 = Util::getIfNotEmpty($book['isbn_13']) ?? "";
                        $this->cover_img = Util::getIfNotEmpty($book["cover_img"]) ?? "";
                        $this->preview_url = Util::getIfNotEmpty($book["preview_url"]) ?? "";
                        $this->via = "openlib";
                        $found = true;
                    } catch (\Exception $e) {
                        $this->sendMessage($e->getMessage(), "error");
                    }
                }
            }
        }
        /* if both the above api don't work we can use amazon to fetch data.*/
        /* Why is amazon not kept as first , they throttle the api request very often , so it becomes unreliable */
        if (Common::getSiteSettings("enable_amazon_fetching") && !$found) {
            // Analysis the amazon api
            try {
                $book = Common::analyseBookDetails($cleanedISBN);
                $this->title = Util::getIfNotEmpty($book["title"]) ?? "";
                $this->isbn_10 = Util::getIfNotEmpty($book['isbn_10']) ?? "";
                $this->isbn_13 = Util::getIfNotEmpty($book['isbn_13']) ?? "";
                $this->cover_img = Util::getIfNotEmpty($book["cover_img"]) ?? "";
                $this->preview_url = Util::getIfNotEmpty($book["preview_url"]) ?? "";
                $this->via = "amazon";
                $found = true;
            } catch (\Exception $e) {
                $this->sendMessage($e->getMessage(), "error");
            }
        }
        if (!$found) {
            $this->reset();
            Session::flash("alert-danger", __("common.no_luck"));
            return;
        }
        $this->sendDescUpdate();
        $this->refresh_js();
    }

    public function sendDescUpdate()
    {
        if ($this->desc) {
            $this->dispatchBrowserEvent("desc_changed", ["desc" => $this->desc]);
        }
    }

    public function checkIfSubBookIdExist($datas)
    {
        $b_id = !empty($datas["b_id"]) ? $datas["b_id"] : $this->book_id;
        $sb_id = $datas["sb_id"];
        $error_send = $datas["error_holder"];
        if (SubBook::where("book_id", $b_id)->where("sub_book_id", $sb_id)->exists()) {
            $this->sendMessage(__("common.book_id_already_exist"), "info");
            $this->submit_id = false;
        } else {
            $this->submit_id = true;
        }
    }

    public function deleteSubBook($datas)
    {
        (new BookCallBacks())->beforeSubBookDeleted();
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $temp = SubBook::find($id);
            if ($temp) {
                // Keeping the borrowed information now on that
                //book doesn't make sense
                Borrowed::whereIn("sub_book_id", [$id])->delete();
                $temp->delete();
                (new BookCallBacks())->afterSubBookDeleted();
                $this->sendMessage(__("common.book_has_been_deleted"), "success");
                $this->searchBookInfo();
            }
        }
    }

    public function savepost(){
    
    
    }
}

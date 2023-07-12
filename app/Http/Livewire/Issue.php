<?php

namespace App\Http\Livewire;

use App\Custom\BookCallBacks;
use App\Facades\Common;
use App\Facades\Util;

use App\Models\Borrowed;
use App\Models\IssueBookReq;
use App\Models\User;
use App\Models\UserNotif;
use App\Traits\CustomCommonLive;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class Issue extends Component
{
    public $book_id_to_issue;
    public $book_img;
    public $user_img;
    public $search_uid;
    public $search_bid;
    use CustomCommonLive;

    public $sel_uid;
    public $sel_mb_id;
    public $sel_sb_id;
    public $sel_issue_date;
    public $sel_return_date;
    public $sel_remark;
    public $sel_barcode_book_id = [];
    public $tmp_barcode_book_id = "";
    public $sel_books_info = [];
    use CustomCommonLive;

    public $allow_issue = false;
    protected $listeners = ["data_manager", "searchBooks", "searchUsers"];

    public function updatedTmpBarcodeBookId()
    {
        if (Str::of($this->tmp_barcode_book_id)->contains(",")) {
            $this->sel_barcode_book_id = array_unique(array_filter(explode(",", $this->tmp_barcode_book_id)));
            $this->tmp_barcode_book_id = implode(",", $this->sel_barcode_book_id) . ",";
        }
        $this->refreshSelectedBarcodeBookInfo();
    }

    public function refreshSelectedBarcodeBookInfo()
    {
        $this->sel_books_info = \App\Models\SubBook::with("book")
            ->whereIn("sub_book_id", $this->sel_barcode_book_id)->where("active", 1)->get();
    }

    public function deleteTmpSelectedBookId($book_id)
    {
        if (in_array($book_id, $this->sel_barcode_book_id)) {
            unset($this->sel_barcode_book_id[array_search($book_id, $this->sel_barcode_book_id)]);
            $this->tmp_barcode_book_id = implode(",", $this->sel_barcode_book_id) . ",";
            $this->refreshSelectedBarcodeBookInfo();
        }
    }

    public function refreshPendingBooks()
    {
        return IssueBookReq::with(["user", "sub_book.book"])->paginate(10);
    }

    public function mount()
    {
        //$this->refreshPendingBooks();
        $this->sel_issue_date = Carbon::now()->toDateString();
        foreach (IssueBookReq::all() as $item) {
            $dbtimestamp = strtotime($item->created_at);
            $reservationtime = strtotime($item->expectedborrow);
            if(time() > $reservationtime){
            if (time() - $dbtimestamp >  72 * 60 * 60){
                $item->delete();
            }
            }
            
        }
    }

    public function data_manager($datas)
    {
        if (isset($datas["issue_date"])) {
            $this->sel_issue_date = $datas["issue_date"];
        }
        if (isset($datas["return_date"])) {
            $this->sel_return_date = $datas["return_date"];
        }
        if (isset($datas["user_id"])) {
            $this->sel_uid = $datas["user_id"];
            if (Common::getNoOfBooksBorrowedCurrently($this->sel_uid) == Common::getLimitOfBookAssigned($this->sel_uid)) {
                $this->sendMessage(__("common.user_has_reached_its_limit_of_borrowing"), "error");
                $this->allow_issue = false;
            }
        }
        if (isset($datas["main_book_id"])) {
            $this->sel_mb_id = $datas["main_book_id"];
        }
        if (isset($datas["sub_book_id"])) {
            $this->sel_sb_id = $datas["sub_book_id"];
        }
    }

    public function all_checks()
    {
        if (!Common::getSiteSettings("enable_bardcode_reading_mode")) {
            if ($this->sel_sb_id && $this->sel_mb_id && $this->sel_issue_date && $this->sel_return_date) {
                if (Carbon::parse($this->sel_issue_date) < Carbon::parse($this->sel_return_date)) {
                    $this->allow_issue = true;
                } else {
                    $this->allow_issue = false;
                    $this->sendMessage(__("common.issue_date_error"), "info");
                }
            }
        } else {
            if (count($this->sel_barcode_book_id) && $this->sel_issue_date && $this->sel_return_date) {
                if (Carbon::parse($this->sel_issue_date) < Carbon::parse($this->sel_return_date)) {
                    $this->allow_issue = true;
                } else {
                    $this->allow_issue = false;
                    $this->sendMessage(__("common.issue_date_error"), "info");
                }
            }
        }
    }

    public function render()
    {
        $this->refreshReturnDP();
        $this->all_checks();
        return view('livewire.issue', ["books_pending" => $this->refreshPendingBooks()]);
    }

    public function attach()
    {
        if (Str::endsWith($this->tmp_barcode_book_id, ",")) {
            if (count($this->sel_books_info)) {
                $this->sendMessage(__("commonv2.done"), "success");
            } else {
                $this->sendMessage(__("commonv2.book_inactive"), "info");
            }
        } else {
            $this->sendMessage(__("commonv2.pl_comma_notice"), "info");
        }
    }

    public function bulkissueBook()
    {
        if (Common::getNoOfBooksBorrowedCurrently($this->sel_uid) < Common::getLimitOfBookAssigned($this->sel_uid)) {
            $selected_sb_ids_objs = $this->sel_books_info;
            $book_issued_cnt = 0;
            foreach ($selected_sb_ids_objs as $sb_id_obj) {
                $check_if_free = \App\Models\SubBook::where("sub_book_id", $sb_id_obj->sub_book_id)->where("borrowed", 0)->first();
                if ($check_if_free) {
                    $tmp = Borrowed::insert(["sub_book_id" => $sb_id_obj->id, "book_id" => $sb_id_obj->book->id,
                        "user_id" => $this->sel_uid,
                        "remark" => $this->sel_remark, "date_borrowed" => $this->sel_issue_date,
                        "date_to_return" => $this->sel_return_date, "issued_by" => \Auth::id()
                        , "working_year" => \App\Facades\Common::getWorkingYear()]);
                    if ($tmp) {
                        $book_issued_cnt = $book_issued_cnt + 1;
                        $temp = \App\Models\SubBook::find($sb_id_obj->id);
                        if ($temp) {
                            $temp->borrowed = 1;
                            $temp->save();
                            IssueBookReq::whereIn("sub_book_id", [$temp->sub_book_id])->delete();
                        }
                    } else {
                        $this->sendMessage(__("common.something_has_gone_wrong") . " with Book ID: " . $sb_id_obj->sub_book_id, "error");
                    }
                } else {
                    $this->sendMessage(__("commonv2.book_already_borrowed"), "error");
                }
            }
            $this->sel_books_info = [];
            $this->sel_barcode_book_id = [];
            $this->tmp_barcode_book_id = "";
            $this->sendMessage(strval($book_issued_cnt) . " Qty of " . __("common.book_has_been_issued"), "success");
        } else {
            $this->sendMessage(__("common.user_has_reached_its_limit_of_borrowing"), "error");
        }
    }

    public function cancelRequest($id)
    {
        $obj = IssueBookReq::find($id);
        if ($obj) {
            $obj->delete();
            $this->sendMessage(__("commonv2.request_rejected"), "success");
            return;
        }
        $this->sendMessage(__("common.id_missing"), "error");
    }

    public function issueBookRequested($user_id, $sub_book_id, $main_book_id)
    {
        $this->sel_uid = $user_id;
        $this->sel_sb_id = $sub_book_id;
        $this->sel_mb_id = $main_book_id;
        if (!$this->sel_return_date) {
            $this->sendMessage(__("commonv2.kindly_sel_data_of_return"), "info");
            return;
        }
        $this->issueBook();
    }

    public function refreshReturnDP()
    {
        $this->dispatchBrowserEvent("refresh_return_dt");
    }

    public function issueBook()
    {
        if (Common::getNoOfBooksBorrowedCurrently($this->sel_uid) < Common::getLimitOfBookAssigned($this->sel_uid)) {
            $check_if_free = \App\Models\SubBook::where("id", $this->sel_sb_id)->where("book_id", $this->sel_mb_id)->where("borrowed", 0)->first();
            if ($check_if_free) {
                list($sel_sb_id, $sel_mb_id, $sel_uid, $sel_issue_date, $sel_return_date) =
                    (new BookCallBacks())->beforeBookIsIssued($this->sel_sb_id, $this->sel_mb_id, $this->sel_uid, $this->sel_issue_date, $this->sel_return_date);
                $tmp = Borrowed::create(["sub_book_id" => $sel_sb_id, "book_id" => $sel_mb_id, "user_id" => $sel_uid,
                    "remark" => $this->sel_remark, "date_borrowed" => $sel_issue_date, "date_to_return" => $sel_return_date, "issued_by" => \Auth::id()
                    , "working_year" => \App\Facades\Common::getWorkingYear()]);
                if ($tmp) {
                    $temp = \App\Models\SubBook::find($this->sel_sb_id);
                    if ($temp) {
                        $temp->borrowed = 1;
                        $temp->save();
                        IssueBookReq::whereIn("sub_book_id", [$temp->sub_book_id])->delete();
                        $this->dispatchBrowserEvent("refresh_user_book_cnt", ["user_id" => $this->sel_uid]);
                        
                    }
                    $this->sel_sb_id = "";
                    $this->all_checks();
                    $notifinfo = [];
                        array_push($notifinfo, array( "User"  => \Auth::Id(),"Action" => "Approved" ,"Target" => $sel_uid,"Modifier" => $sel_mb_id));
                        UserNotif::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Approved","isread" => 0]);
                    (new BookCallBacks())->afterBookIsIssued();
                    
                    $this->sendMessage(__("common.book_has_been_issued"), "success");
                    $this->dispatchBrowserEvent("clear_class", ["class_name" => "book_field_val"]);
                    $this->dispatchBrowserEvent("clear_id", ["id_name" => "book_autocomplete"]);
                } else {
                    $this->sendMessage(__("common.something_has_gone_wrong"), "error");
                }
            } else {
                $this->allow_issue = false;
                $this->sendMessage(__("common.book_already_borrowed"), "error");
            }
        } else {
            $this->sendMessage(__("common.user_has_reached_its_limit_of_borrowing"), "error");
        }
    }

    public function searchBooks()
    {
        $search_bid = $this->search_bid;
        $book = \App\Models\Book::with(["sub_books" => function ($query) use ($search_bid) {
            $query->where("sub_book_id", "like", "%" . $search_bid . "%");
        }])->get();
    }


}

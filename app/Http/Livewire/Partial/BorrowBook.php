<?php

namespace App\Http\Livewire\Partial;

use App\Facades\Common;
use App\Facades\Util;
use App\Models\IssueBookReq;
use App\Models\SubBook;
use App\Models\UserNotif;
use App\Traits\CustomCommonLive;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class BorrowBook extends Component
{
    public $user_id;
    public $sel_return_date;
    public $sel_issue_date;
    public $book_id;
    public $available_books = [];
    public $book_obj;
    public $books_available;
    public $bookqr = "null";
    protected $listeners = ["data_manager",'refreshComponent' => '$refresh'];

    use CustomCommonLive;

    public function render()
    {
        return view('livewire.partial.borrow-book');
    }
    public function encrypt($datas){
    $this->bookqr = Hash::make($datas);
        return  $this->bookqr;
    }
    public function data_manager($datas)
    {
    
        if (isset($datas["issue_date"])) {
            $this->sel_issue_date = $datas["issue_date"];
        }
        if (isset($datas["return_date"])) {
            $this->sel_return_date = $datas["return_date"];
        }
        if(isset($datas["save_data"])){
      
            $this->borrowThis($datas["save_data"]);
        }

    }
    public function listAvailableBooks()
    {
        $this->available_books = SubBook::where("book_id", $this->book_id)->get();
    }

    public function borrowThis($id)
    {
    
     if (isset($this->sel_return_date)){
        $cnt = IssueBookReq::where("user_id", $this->user_id)->count();
        if ($cnt <= (Common::getLimitOfBookAssigned($this->user_id)-Common::getNoOfBooksBorrowedCurrently($this->user_id))) {
            IssueBookReq::create(["user_id" => $this->user_id,"book_id" => $this->book_id, "sub_book_id" => $id,"expectedborrow" => $this->sel_issue_date,"expectedreturn" => $this->sel_return_date,"qrkey" => $this->bookqr]);
            $notifinfo = [];
            array_push($notifinfo, array( "User"  => $this->user_id,"Action" => "Request to Borrow","Target" => $id,"Modifier" => ""));
            UserNotif::Create(["user_id" => $this->user_id,"meta_value" => json_encode($notifinfo),"meta_key" => "Request","isread" => 0]);
            $this->sendMessage(__("commonv2.book_borrowed_wait_for_approval"), "success");
            Log::info("Sended");
        } else {
            $this->sendMessage(__("commonv2.you_hv_reached_ur_limit"), "error");
            Log::info("Limit");
        }
        }else{
            $this->sendMessage(__("commonv2.incomplete_field"), "error");
            Log::info("Error");
        }
        $this->emit('refreshComponent');

    }

    public function cancelThis($id)
    {
    $bookinfo = [];
    array_push($bookinfo, array( "Borrow" => $id));
        $item = IssueBookReq::where("user_id", $this->user_id)->where("sub_book_id", $id)->first();
        $result= UserNotif::where('user_id',$this->user_id)->where("meta_key","Request")->where("meta_value",json_encode($bookinfo))->first();
        if ($item) {
            $item->delete();
        }
        if($result) {
            $result->delete();
        }
        $this->emit('refreshComponent');
    }
}

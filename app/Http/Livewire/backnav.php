<?php

namespace App\Http\Livewire;

use App\Custom\BookCallBacks;
use App\Facades\Common;
use App\Facades\Util;


use Illuminate\Console\Scheduling\Schedule;
Use App\Models\IssueBookReq;
Use App\Models\SubBook;
use App\Traits\CustomCommonLive;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Borrowed;
use App\Models\User;
use App\Models\WebCheckIn;
use App\Models\VisitorTracking;
use App\Models\UserNotif;
use App\Jobs\Heartbeat;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class backnav extends Component
{
    
    public $sel_uid;
    public $sel_mb_id;
    public $sel_sb_id;
    public $sel_issue_date;
    public $sel_return_date;
    public $sel_remark;
    public $sel_barcode_book_id = [];
    public $tmp_barcode_book_id = "";
    public $sel_books_info = [];
    public $key;
    public $decrypt ="";
    protected $listeners = ['backdata_manager','saveTime'];
    public $allow_issue = false;

    public function activeUser(){
    }
    public function backdata_manager($datas)
{

    if(isset($datas)){
    $this->verify($datas);
    }
    
}
    
    public function verify($datas){
     $data = IssueBookReq::where("qrkey", $datas)->first();
     if(isset($data)){
     $this->issueBookRequested($data);
     }elseif(!ctype_xdigit($datas)){
     $this->sendMessage(__("Qr code key doesnt match to any record on the system"), "error");
     }
     else{
     $this->decrypt = hex2bin($datas);
      $try = new WebCheckIn;
     Log::info( $try->insert($this->decrypt));
    $data= DB::select("select date_to_return as Date,Concat('Return') as Try from borroweds where user_id = $this->decrypt and date_returned IS NULL UNION
select expectedborrow as Date,Concat('Checkout') as Try from issue_book_reqs where user_id = $this->decrypt
ORDER BY ABS( DATEDIFF( Date, NOW() ) ) 
");

    if($data[0]->Try == "Checkout"){
    redirect('/checkout/'.$this->decrypt);
    }else{
    redirect('/return/'.$this->decrypt);
    }
     
     }
    }

    public function issueBookRequested($data)
    {
    $sub_book_data = SubBook::where("sub_book_id",$data["sub_book_id"])->first();
        $this->sel_uid = $data["user_id"];
        $this->sel_sb_id = $sub_book_data["id"];
        $this->sel_mb_id = $sub_book_data["book_id"];
        $this->sel_return_date = $data["expectedreturn"];
        $this->sel_issue_date = Carbon::now()->format('Y-m-d');
        $this->remark = "Issued using QR Code";
        Log::info($this->sel_uid ." ".     $this->sel_sb_id ." ". $this->sel_mb_id ." ". $this->sel_return_date ." ". $this->sel_issue_date ." ". $this->remark);
        if (!$this->sel_return_date) {
            
        }
        $this->issueBook();
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

    public function render()
    {
        return view('livewire.backnav');
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
   public function sendMessage($message, $type = 'info')
    {
        $this->dispatchBrowserEvent("show_message",
            ["type" => $type, "title" => "Info", "message" => $message]);
    }

    public function read($params) {
 
           $notifread = new \App\Models\UserNotifread;
           $notifread::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => "read","meta_key" => $params]);
     }
    public function saveTime(){

     $vs = new VisitorTracking();
        $vs->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER["HTTP_USER_AGENT"] : "Bot";
        $vs->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER["HTTP_REFERER"] : "Direct";
            $vs->path = isset($_SERVER['REQUEST_URI']) ? $_SERVER["REQUEST_URI"] : "N/A";
            $vs->username = \Auth::user()->email;
            $vs->time_alive = 1;
              $vs->save();
              
        
      
    }
   
}

<?php

namespace App\ Models;

use App\ Traits\ CustomCache;
use Illuminate\ Database\ Eloquent\ Factories\ HasFactory;
use Illuminate\ Database\ Eloquent\ Model;
use Illuminate\ Support\ Facades\ Auth;
use Illuminate\ Support\ Str;
use Illuminate\Support\Facades\DB;

class UserNotif extends Model {
  use CustomCache;
  use HasFactory;

  protected $guarded = ["id"];

  public $notifcount =0;
  public function get_Cancelled() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_Request() {
    $tmp = UserNotif::where("meta_key", "Request")->where("archive", "0")->get();
    $data = [];
    foreach($tmp as $temp) {
      array_push($data, json_encode($temp->meta_value, true));
    }

    return $data ? $data : "";
  }
  
  public function get_Approved() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }

  
  public function get_OwnDeadline() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_Deadline() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_MonthlyDeadline() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_PastOverDue() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_LastDayDeadline() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_NewBooks() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_promotion() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_OutofStock() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_MonthlyOutstock() {
    $tmp = UserNotif::where("meta_key", "address")->where("user_id", Auth::id())->first();
    return $tmp ? $tmp->meta_value : "";
  }
  
  public function get_NewBookPost() {

  }
  
  public function get_NewNotice() {

  }
  
  public function get_NewCarousel() {

  }
  
  public function get_NewEnquiry() {

  }
  
  public function get_NewBookMgmt() {

  }
  
  public function get_NewNotes() {

  }
  
  public function get_NewAchievement() {

  }

  
  public function verify($perm) {
    
    $data = [];
    if ($perm == "mng-notif-admin") {
    $mngnotif = ["Request", "Approved", "NewBook", "Promotion", "Notice", "Carousel", "Enquiries", "ReturnAlert","Message","Return","Dewey"];
    $implo = "'".implode("','", $mngnotif)."'";
      $tmp = UserNotif::whereIn("meta_key", $mngnotif)->where("archive", "0")->orderby("id", "DESC")->get();
      $tmpe = UserNotif::whereIn("meta_key", $mngnotif)->where("archive", "0")->orderby("id", "DESC")->count();
      $notif =0;
      $rawcount = DB::select("select count(*) as qty from `user_notifs` a JOIN user_notifreads b on a.id = b.id
where a.meta_key
in ($implo)
 and `archive` = '0'
order by a.id");

foreach($rawcount as $count){

$notif = $count->qty;
}
       $notif = $tmpe - $notif;
       $this->notifcount = $notif;
      foreach($tmp as $temp) {
        $newdata = array(
          'id' => $temp->id,
          'created_at' => $temp->created_at,
          'archive' => $temp->archive,
          'Meta_key' => $temp->meta_key,
          'isread' => $temp->isread);
        $try = json_decode($temp->meta_value, true);
        $final = array_merge($newdata, $try[0]);

        array_push($data, $final);

      }
    }elseif($perm == "mng-notif-librarian") {
      $mngnotif = ["Request", "Approved", "NewBook", "Promotion", "Notice", "Carousel", "Enquiries", "ReturnAlert","Message"];
      $tmp = UserNotif::whereIn("meta_key", $mngnotif)->where("archive", "0")->orderby("id", "DESC")->get();
      foreach($tmp as $temp) {
        $newdata = array(
          'id' => $temp->id,
          'created_at' => $temp->created_at,
          'archive' => $temp->archive,
          'Meta_key' => $temp->meta_key,
          'isread' => $temp->isread);
        $try = json_decode($temp->meta_value, true);
        $final = array_merge($newdata, $try[0]);

        array_push($data, $final);

      }
    }elseif($perm == "mng-notif-sa") {
      $mngnotif = ["Request", "NewBook", "Promotion", "Enquiries", "ReturnAlert","Message"];
      $tmp = UserNotif::whereIn("meta_key", $mngnotif)->where("archive", "0")->orderby("id", "DESC")->get();
      foreach($tmp as $temp) {
        $newdata = array(
          'id' => $temp->id,
          'created_at' => $temp->created_at,
          'archive' => $temp->archive,
          'Meta_key' => $temp->meta_key,
          'isread' => $temp->isread);
        $try = json_decode($temp->meta_value, true);
        $final = array_merge($newdata, $try[0]);

        array_push($data, $final);

      }
    }elseif($perm == "mng-notif-regular") {

      $mngnotif = ["NewBook","Message","Approved","ReturnAlert"];
      $tmp = UserNotif::where('meta_value', 'like', '%'.Auth::id().'%')->where("archive", "0")->orderby("id", "DESC")->get();
      
      foreach($tmp as $temp) {
        
        $try = json_decode($temp->meta_value, true);
        if (in_array($temp->meta_key , $mngnotif)) {
        $newdata = array(
          'id' => $temp->id,
          'created_at' => $temp->created_at,
          'archive' => $temp->archive,
          'Meta_key' => $temp->meta_key,
          'isread' => $temp->isread,
          'Useralt' => "You");
        $final = array_merge($newdata, $try[0]);
        array_push($data, $final);
        } elseif($temp->user_id == Auth::id()) {
        $newdata = array(
          'id' => $temp->id,
          'created_at' => $temp->created_at,
          'archive' => $temp->archive,
          'Meta_key' => $temp->meta_key,
          'isread' => $temp->isread,
          'Useralt' => "You",
          'role' => "Regular");
        $final = array_merge($newdata, $try[0]);
        array_push($data, $final);
        }
        
        
        

      }

      
    }
    return $data ? $data : "";
    }
    //get_promotion  
    //get_newbookpost
    //get_NewNotice
    //get_NewCarousel
    //get_NewEnquiry
    //
    //get_NewAchievement
    //get_NewNotes
    //get_NewBookMgmt
    //get_Cancelled
    //get_Approved
    //get_MonthlyOutstock
    //get_Request
    //get_Deadline
    //get_MonthlyOutstock
    //get_PastOverDue
    //get_LastDayDeadline
    //get_NewBooks()
    //get_promotion()
    //get_OutofStock  
    //get_OwnDeadline()
    //
    //}elseif($perm="mng-notif-librarian"){
    //
    //get_NewAchievement
    //get_NewNotes
    //get_NewBookMgmt
    //get_Cancelled
    //get_Approved
    //get_MonthlyOutstock
    //get_Request
    //get_Deadline
    //get_MonthlyOutstock
    //get_PastOverDue
    //get_LastDayDeadline
    //get_NewBooks()
    //get_promotion()
    //get_OutofStock  
    //get_OwnDeadline()
    //}
    //elseif($perm="mng-notif-sa"){
    //get_Request
    //get_Deadline
    //get_MonthlyOutstock
    //get_PastOverDue
    //get_LastDayDeadline
    //get_NewBooks()
    //get_promotion()
    //get_OutofStock  
    //get_OwnDeadline()
    //get_NewAchievement  
    //
    //
    //
    //}
    //elseif($perm="mng-notif-regular"){
    //get_promotion()
    //get_NewBooks()
    //get_OwnDeadline()
    //get_NewAchievement
    //}

    //get permission
    //book borrow
    //deadline
    //confirmation (approved/rejected)//
    //Borrow Request, Cancelled Request,S,a Approves, Librarian Approved, Day before deadline ,Deadline,New Books, 

  }

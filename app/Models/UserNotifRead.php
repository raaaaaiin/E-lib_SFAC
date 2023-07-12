<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserNotifread extends Model
{
    use CustomCache;
    use HasFactory;

    protected $guarded = ["id"];
    public function verifynotif($id){//verify if post is read,unread,archived,unarchived
    $tmp = UserNotifread::where("user_id", Auth::Id())->where("meta_key",$id)->get();
    $result = array("read" => 0,
    "unread" =>0,
    "archived" =>0,
    "unarchived" =>0);
    foreach($tmp as $data){
    
        if($data->meta_value =="read"){
        $result["read"] = 1;
        $result["unread"] = 0;
        }elseif($data->meta_value =="unread"){
        $result["unread"] = 1;
        $result["read"] = 0;
        }elseif($data->meta_value =="archived"){
        $result["archived"] = 1;
        $result["unarchived"] = 0;
        }elseif($data->meta_value =="unarchived"){
        $result["unarchived"] = 1;
        $result["archived"] = 0;
    }
    }
    return $tmp ? $result : array("read" => 0,
    "unread" =>0,
    "archived" =>0,
    "unarchived" =>0) ;
    }
    /*User
Action
Target
Modifier


Name Cancelled Borrowing BookTitle / 

Name Request to Borrow Booktitle /

Name Approved Raineer Request: Book Title /

Name/You Must return : book title / 

Your Borrowed book is overdue for a month /

Your borrowed book is overdue for a week /

Your have only 1 day left to return : book title /

@Everyone Check out this new Book :LSLSLS /

Name Promoted NANANA to Student assistance /

Name Demoted nanana to current role / 

Raineer! This book is out of stock : Title /

Administrator Posted new book : Title / 

Administrator Posted new notice : To/

Administrator Added new carousel : Target /

Administrator Removed Carousel : targer /

Administrator added new Enquiry /

Administrator deleted Enquiry : Target /

Administrator added Bookmgmt : target

Administrator deleted Bookmgmt : target

Administrator Added Notes : target

Administrator Delete Notes : target

Name is the new :Achiever 

*/
    
    
}

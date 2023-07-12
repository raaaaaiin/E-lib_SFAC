<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookMeta Extends Model
{
public $timestamps = true;//meta has
// views
// borrower
// clicked
// visitorcount
// read

    use CustomCache;
    use HasFactory;
    protected $table = "book_metas";
    protected $fillable = ["meta_value","meta_key","unique_id",];


    public function get_borrower($unique_id)
    {
        if (!isset($this->unique_id)) {
            $tmp = BookMeta::where("meta_key", "borrower")->where("unique_id", $this->unique_id)->first();
        } else {
            $tmp = BookMeta::where("meta_key", "borrower")->where("unique_id", $this->unique_id)->first();
        }
        return $tmp ? $tmp->meta_value : "";
    }
    public function get_borrowerCount($unique_id){
    
        if (!isset($this->unique_id)) {
            $tmp = BookMeta::where("meta_key", "borrower")->where("unique_id", $this->unique_id)->get();
        } else {
            $tmp = BookMeta::where("meta_key", "borrower")->where("unique_id", $this->unique_id)->get();
        }
        return $tmp ? $tmp->meta_value : "";
    }
    public function get_views($unique_id)
    {
   
        if (!isset($unique_id)) {
            $tmp = BookMeta::where("meta_key", "views")->where("unique_id", $unique_id)->first();
        } else {
        
            $tmp = BookMeta::where("meta_key", "views")->where("unique_id", $unique_id)->first();
        }
        return $tmp ? $tmp->meta_value : "";
    }
    public function get_read($unique_id)
    {
        if (!isset($this->unique_id)) {
            $tmp = BookMeta::where("meta_key", "read")->where("unique_id", $this->unique_id)->get();
        } else {
            $tmp = BookMeta::where("meta_key", "read")->where("unique_id", $this->unique_id)->get();
        }
        return $tmp ? $tmp->meta_value : "";
    }
    public function get_recent_read($unique_id)
    {
        if (!isset($this->unique_id)) {
            $tmp = BookMeta::where("meta_key", "read")->where("unique_id", $this->unique_id)->first();
        } else {
            $tmp = BookMeta::where("meta_key", "read")->where("unique_id", $this->unique_id)->first();
        }
        return $tmp ? $tmp->meta_value : "";
    }
    public function get_click($unique_id)
    {
        if (!isset($this->$unique_id)) {
            $tmp = BookMeta::where("meta_key", "click")->where("unique_id", $this->unique_id)->first();
        } else {
            $tmp = BookMeta::where("meta_key", "click")->where("unique_id", $this->unique_id)->first();
        }
        return $tmp ? $tmp->meta_value : "";
    }
    public function get_visited($unique_id)
    {
        if (!isset($this->$unique_id)) {
            $tmp = BookMeta::where("meta_key", "address")->where("unique_id", $this->unique_id)->first();
        } else {
            $tmp = BookMeta::where("meta_key", "address")->where("unique_id", $this->unique_id)->first();
        }
        return $tmp ? $tmp->meta_value : "";
    }
}

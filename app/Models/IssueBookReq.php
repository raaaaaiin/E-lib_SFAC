<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueBookReq extends Model
{
    use HasFactory;
    protected $guarded=["id"];
    public function sub_book(){
        return $this->belongsTo(SubBook::class,"sub_book_id","sub_book_id");
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

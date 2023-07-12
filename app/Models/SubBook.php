<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubBook extends Model
{
    protected $table = "sub_books";
    use HasFactory;
    protected $guarded = ["id"];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function user_damaged(){
        return $this->hasOne(User::class,"id","damaged_by");
    }
    public function user_lost(){
        return $this->hasOne(User::class,"id","lost_by");
    }
    public static function get_book_name($sub_book){

    $last = "Null";
        $tmp = SubBook::where('sub_book_id',$sub_book)->get();
        
       
        if (!$tmp) {
            return "N/A";
        }else{
            foreach($tmp as $data){
            $book = Book::where('id',$data->book_id)->get();
            foreach($book as $final){
                $last = $final->title;
            }
        }
        }
        return $last ? $last : "Null";
    }public static function get_directbook_name($book_id){

    $last = "Null";
       
        
       
            $book = Book::where('id',$book_id)->get();
            foreach($book as $final){
                $last = $final->title;
            }
        
        return $last ? $last : "Null";
    }public static function get_directuniquebook_name($unique){

    $last = "Null";
       
        
       
            $book = Book::where('unique_id',$unique)->get();
            foreach($book as $final){
                $last = $final->title;
            }
        
        return $last ? $last : "Null";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    public $timestamps = true;
    public function sub_books()
    {
        return $this->hasMany(SubBook::class);
    }
    public function cover_img(){
        if($this->cover_img){
            if(\File::exists(public_path("uploads/".$this->cover_img))){
                return asset('uploads/'.$this->cover_img,false);
            }
        }
        if(\File::exists(public_path("uploads/".$this->id.".jpg"))){
            return asset('uploads/'.$this->id.".jpg",false);
        }
        if(\File::exists(public_path("uploads/".$this->unique_id.".jpg"))){
            return asset('uploads/'.$this->unique_id.".jpg",false);
        }
        if(\File::exists(public_path("uploads/".$this->isbn_10.".jpg"))){
            return asset('uploads/'.$this->isbn_10.".jpg",false);
        }
        if(\File::exists(public_path("uploads/".$this->isbn_13.".jpg"))){
            return asset('uploads/'.$this->isbn_13.".jpg",false);
        }
        return asset('uploads/'.config("app.DEFAULT_BOOK_IMG"),false);
    }
    public function authors(){
        return $this->belongsToMany(Author::class,"book_author");
    }
    public function publishers(){
        return $this->belongsToMany(Publisher::class,"book_publisher");
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,"book_tag");
    }
    public function medtypes(){
        return $this->belongsToMany(Medtype::class,"book_medtype");
    }
    public function category(){
        return $this->hasOne(DeweyDecimal::class,"id","category");
    }
       public static function get_book_name($unique_id){
       
        $tmp = Book::where('unique_id',$unique_id)->get();
        $data = "";
       
        if (!$tmp) {
            return "N/A";
        }else{
            foreach($tmp as $data){
                $data = $data->title;
            
        }
        }
        return $data ? $data : "Null";
    }public static function get_book_name_byID($id){
       
        $tmp = Book::where('id',$id)->get();
        $data = "";
       
        if (!$tmp) {
            return "N/A";
        }else{
            foreach($tmp as $data){
                $data = $data->title;
            
        }
        }
        return $data ? $data : "Null";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medtype extends Model
{
    use HasFactory;
    protected $guarded=["id"];
    public function books(){
        return $this->belongsToMany(Book::class,"book_medtype");
    }
}

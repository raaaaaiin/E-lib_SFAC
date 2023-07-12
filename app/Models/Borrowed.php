<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowed extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = ["id"];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function sub_book()
    {
        return $this->belongsTo(SubBook::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issued_by_person()
    {
        return $this->belongsTo(User::class, "issued_by", "id");
    }

}

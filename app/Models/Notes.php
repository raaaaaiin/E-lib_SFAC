<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $casts = ["files_attached" => "array"];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

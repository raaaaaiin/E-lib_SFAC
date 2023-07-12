<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTag extends Model
{
    protected $table="book_tag";
    public $timestamps = true;
    use HasFactory;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMedtype extends Model
{
    protected $table="book_medtype";
    public $timestamps = true;

    use HasFactory;
}

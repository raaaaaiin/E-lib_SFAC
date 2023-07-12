<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPublisher extends Model
{
    protected $table="book_publisher";
    public $timestamps = true;

    use HasFactory;
}

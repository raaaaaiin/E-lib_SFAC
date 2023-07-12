<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
    //
    use CustomCache;
    use SoftDeletes;
    protected $table = "year";
    protected $guarded = ["id"];
}

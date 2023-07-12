<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    use CustomCache;
    protected $guarded = ["id"];
}

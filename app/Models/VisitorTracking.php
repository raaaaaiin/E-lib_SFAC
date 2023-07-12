<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorTracking extends Model
{
    use HasFactory;
    use CustomCache;
    protected $guarded=["id"];
}

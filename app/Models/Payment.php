<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    use SoftDeletes;
    use CustomCache;


    public function borrowed(){
        return $this->belongsTo(Borrowed::class);
    }

}

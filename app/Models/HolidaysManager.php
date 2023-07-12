<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HolidaysManager extends Model
{
    //
    protected $table = "Holidays";
    protected $guarded = ["id"];
    protected $casts = [
        'role_id' => 'array',
        'user_id' => 'array',
    ];
}

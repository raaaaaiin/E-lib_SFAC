<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeManager extends Model
{
    //
    protected $guarded = ["id"];
    protected $casts = [
        'role_id' => 'array',
        'user_id' => 'array',
    ];
}

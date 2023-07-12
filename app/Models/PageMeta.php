<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageMeta extends Model
{
    //
    protected $guarded = ["id"];

    public function get_page()
    {
        $this->hasOne("App/Page", "id");
    }
}

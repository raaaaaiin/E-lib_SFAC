<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserDataMeta extends Model
{
    use CustomCache;
    use HasFactory;
    protected $table = "user_datametas";
    public $timestamps = true;
    protected $guarded = ["id"];

    public function getSearchesRecomendation($userid = null)
    {
        if (!isset($userid)) {
            $tmp = UserDataMeta::where("meta_key", "Searches")->get();
        } else {
            $tmp = UserDataMeta::where("meta_key", "Searches")->where("user_id", $userid)->get();
        }
        return $tmp ? $tmp->meta_value : "";


    }

    
}

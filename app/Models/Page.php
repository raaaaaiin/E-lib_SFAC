<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    use CustomCache;
    protected $guarded = ["id"];

    public function get_metas()
    {
        $this->hasMany(PageMeta::class, "id");
    }

    public static function get_meta_by_key($page_id, $meta_key)
    {
        $tmp = PageMeta::where("meta_key", $meta_key)->where("page_id", $page_id)->first();
        if ($tmp) {
            return $tmp->meta_value;
        }
        return "";
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "category_pages");
    }
}

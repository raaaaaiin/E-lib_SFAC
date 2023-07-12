<?php

namespace App\Models;

use App\Traits\CustomCache;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    use CustomCache;
    protected $guarded = ["id"];

    public static function get_sub_cat($parent_id)
    {
        return Category::where("parent", $parent_id)->get();
    }

    public static function get_parent_cats()
    {
        return Category::where("parent", 0)->get();
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, "category_pages");
    }
}

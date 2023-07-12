<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeweyDecimal extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function childrens()
    {
        return $this->hasMany(DeweyDecimal::class, "parent", "id");
    }
    public function sub_childrens()
    {
        return $this->hasMany(DeweyDecimal::class, "sub_parent", "parent");
    }

    public function catImage()
    {
        if ($this->image) {
            if (\File::exists(public_path("uploads/" . $this->image))) {
                return $this->image;
            } else {
                return config("app.DEFAULT_CAT");
            }
        }
        return config("app.DEFAULT_CAT");
    }
}

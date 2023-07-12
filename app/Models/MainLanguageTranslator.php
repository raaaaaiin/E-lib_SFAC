<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainLanguageTranslator extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function translations()
    {
        return $this->hasMany(LanguageTranslator::class, "main_language_translator_id", "id");
    }


}

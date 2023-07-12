<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageTranslator extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function main_translation()
    {
        return $this->belongsTo(MainLanguageTranslator::class,"main_language_translator_id","id");
    }
    function insertOrUpdate(array $rows)
    {
        $table = \DB::getTablePrefix() . with(new self)->getTable();
        $first = reset($rows);
        $columns = implode(',',
            array_map(function ($value) {
                return "$value";
            }, array_keys($first))
        );
        $values = implode(',', array_map(function ($row) {
                return '(' . implode(',',
                        array_map(function ($value) {
                            return '"' . str_replace('"', '""', $value) . '"';
                        }, $row)
                    ) . ')';
            }, $rows)
        );
        $updates = implode(',',
            array_map(function ($value) {
                return "$value = VALUES($value)";
            }, array_keys($first))
        );
        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";
        return \DB::statement($sql);
    }
}

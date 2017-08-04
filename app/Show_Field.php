<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show_Field extends Model
{
    protected $table="show_fields";


    // Список полей для таблицы
    public static function getAll($table) 
    {
		return self::select('*')->where("name_table", "=", $table)->orderBy('order');
    }


}

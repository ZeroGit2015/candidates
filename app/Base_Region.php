<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base_Region extends Model
{
    // Плохо работает со знаком подчеркивания - имя таблицы указываю четко 
    protected $table = 'base_regions';
	
	// Список регионов
    public function getAll() 
    {
		return $this->select('base_regions.*')->orderBy('base_regions.id');
    }	

    // Список кураторов
    public function kurators()
    {
		return $this->distinct()->select('base_regions.kurator')->where("kurator", "!=", "")->orderBy('base_regions.kurator');
    }

}

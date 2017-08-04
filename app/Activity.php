<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table="activity";


	// Список регионов
    public function getAll() 
    {
		return $this->select('activity.*')->orderBy('activity.name');
    }	

}

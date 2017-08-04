<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table="statuses";


	// Список статусов
    public function getAll($name_table='', $id_election=FALSE) 
    {
    	$result = $this->select('statuses.*')->where('name_table', "=", $name_table);
    	if ($id_election) {
    		$result = $result->where('id_election', "=", $id_election);
    	}
    	$result = $result->orderBy('statuses.id');
		return $result;
    }	
}

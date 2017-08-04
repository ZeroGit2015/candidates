<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election_Okrug extends Model
{
    protected $table="election_okrugs";


	// Список округов
    public function getAll($id_election) 
    {
		return $this->select("{$this->table}.*")->where("id_election", "=", $id_election)->orderBy("{$this->table}.name");
    }	

}

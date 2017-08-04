<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate_Election_Okrug extends Model
{

    protected $table = 'candidate_election_okrugs';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'created_at', 'updated_at'];


    public function saveElectionOkrugs($id_candidate, $inputs) {
    	// Удаляю ненужные
    	$res = $this->where("id_candidate", "=", $id_candidate)->get();
    	$candidate_election_okrugs = [];
    	foreach ($res AS $value) {
    		if (!isset($inputs['candidate_election_okrugs'][$value->id_election]) or !in_array($value->id_election_okrug, $inputs['candidate_election_okrugs'][$value->id_election])) {
		   		$this->find($value->id)->delete();
    		} else {
				$candidate_election_okrugs[$value->id_election][] = $value->id_election_okrug;
    		}
    	}
    	// Добавляю отсутствующие
    	if (isset($inputs['candidate_election_okrugs'])) {
    		foreach ($inputs['candidate_election_okrugs'] AS $id_election => $okrugs) {
    			foreach ($okrugs AS $key => $value) {
	    			if (!isset($candidate_election_okrugs[$id_election]) or !in_array($value, $candidate_election_okrugs[$id_election])) {
		    			$new = new Candidate_Election_Okrug();
    					$new->id_candidate = $id_candidate;
    					$new->id_election = $id_election;
    					$new->id_election_okrug = $value;
	    				$new->save();
		    		}
	    		}
    		}
    	}
    } 

}

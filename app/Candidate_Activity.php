<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate_Activity extends Model
{
    protected $table = 'candidate_activities';
	// Ïîëÿ, êîòîğûå íå îáíîâëÿşòñÿ
	protected $guarded = ['id', 'created_at', 'updated_at'];


    public function saveActivities($id_candidate, $inputs) {
    	// Óäàëÿş íåíóæíûå
    	$res = $this->where("id_candidate", "=", $id_candidate)->get();
    	$candidate_activities = [];
    	foreach ($res AS $value) {
    		if (!isset($inputs['candidate_activities']) or !in_array($value->id_activity, $inputs['candidate_activities'])) {
		   		$this->find($value->id)->delete();
    		} else {
				$candidate_activities[] = $value->id_activity;
    		}
    	}
    	// Äîáàâëÿş îòñóòñòâóşùèå
    	if (isset($inputs['candidate_activities'])) {
    		foreach ($inputs['candidate_activities'] AS $key => $value) {
    			if (!in_array($value, $candidate_activities)) {
	    			$new = new Candidate_Activity();
    				$new->id_candidate = $id_candidate;
    				$new->id_activity = $value;
	    			$new->save();
	    		}
    		}
    	}
    } 

}

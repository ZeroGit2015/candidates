<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert_Activity extends Model
{
    protected $table = 'expert_activities';
	// Ïîëÿ, êîòîğûå íå îáíîâëÿşòñÿ
	protected $guarded = ['id', 'created_at', 'updated_at'];


    public function saveActivities($id_expert, $inputs) {
    	// Óäàëÿş íåíóæíûå
    	$res = $this->where("id_expert", "=", $id_expert)->get();
    	$expert_activities = [];
    	foreach ($res AS $value) {
    		if (!isset($inputs['expert_activities']) or !in_array($value->id_activity, $inputs['expert_activities'])) {
		   		$this->find($value->id)->delete();
    		} else {
				$expert_activities[] = $value->id_activity;
    		}
    	}
    	// Äîáàâëÿş îòñóòñòâóşùèå
    	if (isset($inputs['expert_activities'])) {
    		foreach ($inputs['expert_activities'] AS $key => $value) {
    			if (!in_array($value, $expert_activities)) {
	    			$new = new Expert_Activity();
    				$new->id_expert = $id_expert;
    				$new->id_activity = $value;
	    			$new->save();
	    		}
    		}
    	}
    } 

}

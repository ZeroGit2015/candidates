<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate_Activity extends Model
{
    protected $table = 'candidate_activities';
	// ����, ������� �� �����������
	protected $guarded = ['id', 'created_at', 'updated_at'];


    public function saveActivities($id_candidate, $inputs) {
    	// ������ ��������
    	$res = $this->where("id_candidate", "=", $id_candidate)->get();
    	$candidate_activities = [];
    	foreach ($res AS $value) {
    		if (!isset($inputs['candidate_activities']) or !in_array($value->id_activity, $inputs['candidate_activities'])) {
		   		$this->find($value->id)->delete();
    		} else {
				$candidate_activities[] = $value->id_activity;
    		}
    	}
    	// �������� �������������
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate_Election extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Дополнительные функции для модели
    |--------------------------------------------------------------------------
    |
    | Параметры полей и таблицы
    | getFieldsList, getFieldParams
    |
    */
    use TableFunctions;

    protected $table = 'candidate_elections';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'created_at', 'updated_at'];

    public function saveElections($id_candidate, $inputs) {
    	// Удаляю ненужные
    	$res = $this->where("id_candidate", "=", $id_candidate)->get();
    	// Массив выборов кандидата
    	$candidate_elections = [];
    	foreach ($res AS $value) {
    		if (!isset($inputs['candidate_elections']) or !array_key_exists($value->id_election, $inputs['candidate_elections'])) {
		   		$this->find($value->id)->delete();
    		} else {
				$candidate_elections[$value->id_election] = $value;
    		}
    	}
    	// Добавляю отсутствующие
    	if (isset($inputs['candidate_elections'])) {
    		foreach ($inputs['candidate_elections'] AS $id_election => $value) {
    			if (!array_key_exists($id_election, $candidate_elections)) {
	    			$new = new Candidate_Election();
    				$new->id_candidate = $id_candidate;
    				$new->id_election = $id_election;
    				$new->list_position = $value['list_position'];
    				$new->id_status = $value['id_status'];
    				$new->speaker = $value['speaker'];
    				$new->speaker_info = $value['speaker_info'];
    				$new->speaker_itog = $value['speaker_itog'];
	    			$new->save();
	    		}
    		}
    	}
    	// Сохраняю измененные поля
    	if (isset($inputs['candidate_elections'])) {
    		foreach ($inputs['candidate_elections'] AS $id_election => $value) {
    		    if (array_key_exists($id_election, $candidate_elections)) {
	    			$update = Candidate_Election::find($candidate_elections[$id_election]->id);
    				if ($value['list_position']!=$update->list_position) {
    					$update->update(['list_position'=>$value['list_position'], 'id_status'=>$value['id_status'], 'speaker'=>$value['speaker'], 'speaker_info'=>$value['speaker_info'], 'speaker_itog'=>$value['speaker_itog']]);
		    		}
	    		}
    		}
    	}
    
    } 

}

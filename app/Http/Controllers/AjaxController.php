<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\A;
use App\Candidate;
use App\Candidate_Activity;
use App\Candidate_Election;
use App\Candidate_Election_Okrug;
use App\Election;
use App\Election_Okrug;
use App\Status;

// КОНТРОЛЛЕР AJAX ЗАПРОСОВ
class AjaxController extends Controller
{

    public function getIndex(Request $request) {
    	echo "error";
    	exit;
    }


    // Сохранение кандидата
    public function anySaveCandidate(Candidate $candidate, Candidate_Activity $candidate_activity, Candidate_Election $candidate_election, Candidate_Election_Okrug $candidate_election_okrug, Request $request) {
		$v = $candidate->validate($request);

		$status =  $href = "";

		if ($v->fails()) {
			$status = implode(",", $v->errors()->all());
		} else {
			$id_candidate = $candidate->saveCandidate($request->all());
			// Выборы
			$candidate_election->saveElections($id_candidate, $request->all());
			// Деятельности
			$candidate_activity->saveActivities($id_candidate, $request->all());
			// Округа
			$candidate_election_okrug->saveElectionOkrugs($id_candidate, $request->all());

			$status = "OK";
			$href = "/candidates/{$id_candidate}/view";
		}


		$result = [
			"status" 	=> $status,
			"href"		=> $href,
		];
		return json_encode($result);
    	exit;
    }


    // Проверка кандидата на дубль
    public function anyCheckCandidate(Candidate $candidate, Request $request) {
    	$status  = "OK";
    	$message = "";
    	if (count($candidate->checkCandidate($request->all()))) {
    		$status  = "double";
    		$message = "Кандидат '{$request->get("fio")}' уже есть в базе. \n Все равно настаиваете на добавлении?";
    	}
		$result = [
			"status" 	=> $status,
			"message"	=> $message,
		];
    	return json_encode($result);
    	exit;
    }

    // Вывод выборов в шаблоне редактирования кандидата
    public function anyGetElectionForFormEdit(Election_Okrug $election_okrugs, Election $elections, Status $statuses, Request $request) {

        $okrugs = [];
        if ($request['id_election']) {
	       	$election = $elections->find($request['id_election']);
	       	// Для совместимости
	       	$election->id_election = $election->id;
	        if ($election->have_okrugs) {
	        	$election->list_position = "";
    	    	$okrugs = $election_okrugs->getAll($request['id_election'])->get();
    	    	foreach ($okrugs AS $key=>$value) { $okrugs[$key]['selected'] = ""; }
	        }
	        $statuses =  $statuses->getAll('candidates', $request['id_election'])->get();
	    }

		$result = view("election_edit")->with(
	    	  ["okrugs"=>$okrugs, "election"=>$election, 'statuses'=>$statuses]
	    )->render();

    	return json_encode(["result"=>$result]);
    	exit;
    }

    // Список групп выборов региона
    public function anyGetElectionGroups(Election $elections, Request $request) {

        $result["status"] ="OK";
       	$data = [""];
        if ($request['election_region']) {
	       	$election_groups = $elections->getGroups($request['election_region'])->get();
	       	foreach ($election_groups AS $group) {$data[$group['group']]=$group['group'];}
	    }
		$result["election_groups"] = $data;

    	return json_encode(["result"=>$result]);
    	exit;
    }


    // Список имен выборов региона и группы
    public function anyGetElectionNames(Election $elections, Request $request) {

        $result["status"] ="OK";
       	$data = [""];
        if ($request['election_region']) {
	       	$election_names = $elections->getNames($request['election_region'], $request['election_group'])->get();
	       	foreach ($election_names AS $name) {$data[$name['name']]=$name['name'];}
	    }
		$result["election_names"] = $data;

    	return json_encode(["result"=>$result]);
    	exit;
    }


    // Список имен статусов региона и группы
    public function anyGetElectionStatuses(Election $elections, Request $request) {

        $result["status"] ="OK";
       	$data = [""];
        if ($request['election_region']) {
	       	$election_statuses = $elections->getStatuses($request['election_region'], $request['election_group'], $request['election_name'])->get();
	       	foreach ($election_statuses AS $status) {$data[$status['id']]=$status['name'];}
	    }
		$result["election_statuses"] = $data;

    	return json_encode(["result"=>$result]);
    	exit;
    }


}

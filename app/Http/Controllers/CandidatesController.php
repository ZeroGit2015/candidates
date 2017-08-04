<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Candidate;
use App\Candidate_Comment;
use App\Base_Region;
use App\Election;
use App\Status;
use App\User;
use App\Show_Field;
use App\Candidate_Election;
use App\Candidate_Activity;
use App\Activity;
use Session;

class CandidatesController extends Controller
{
	private $use_it;

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Таблица, формы просмотра и редактирования
    public function getIndex(Candidate $candidate, Base_Region $base_region, Activity $activity, Election $election, Status $status, User $user, Request $request, $id_candidate= '', $operation = '')
    {
        if (!$id_candidate) {
			// В случае, если query возвращает ошибку - сбрасываю фильтр и сортировку
			try {
				$results = $candidate->getAll()->get();
			} catch (\Exception $e) {
    			
    			$candidate->setFilter();
    			$candidate->setOrderByField();

				$results = $candidate->getAll()->get();
			}
			$params = $user->getParams();
	        return view('candidates')->with(["results"=>$results, "showFields"=>$candidate->getFieldsForShow(), 'regions'=>$base_region->getAll()->get(), 'statuses'=>$status->getAll('candidates')->get(), 'election_regions'=>$election->getRegions()->get(), 'election_groups'=>$election->getGroups(@$params['candidates']['filters']['election_region']['value'])->get(), 'election_names'=>$election->getNames(@$params['candidates']['filters']['election_region']['value'], @$params['candidates']['filters']['election_group']['value'])->get(), 'election_statuses'=>$election->getStatuses(@$params['candidates']['filters']['election_region']['value'], @$params['candidates']['filters']['election_group']['value'], @$params['candidates']['filters']['election_name']['value'])->get(), 'activities'=>$activity->getAll()->get(), 'kurators'=>$base_region->kurators()->get(), 'params'=>$params]);
	    } else {
	    	if ((int)($id_candidate)>0) {
	    		if (!is_null($candidate->find($id_candidate))) {
	    			switch ($operation) {
		    			// Печать
		    			case 'print':
		    				return view("candidate_print")->with(['data'=>$candidate->find($id_candidate), 'regions'=>$base_region->getAll()->get(), 'elections'=>$election->getAll()->orderByDefault()->get(), 'activities'=>$activity->getAll()->get()]);
		    			 	break;
		    			// Редактирование
		    			case 'edit':
		    				return view("candidate_edit")->with([ 'data'=>$candidate->find($id_candidate), 'regions'=>$base_region->getAll()->get(), 'elections'=>$election->getAll()->orderByDefault()->get(), 'activities'=>$activity->getAll()->get()]);
		    			 	break;
						// Журнал
		            	case "log":
		    				return view("candidate_log")->with(['data'=>$candidate->find($id_candidate)]);
		            		break;
		    			// Просмотр
		    			case 'view':
		    			default:
		    				return view("candidate_view")->with(['data'=>$candidate->find($id_candidate), 'regions'=>$base_region->getAll()->get(), 'elections'=>$election->getAll()->orderByDefault()->get(), 'activities'=>$activity->getAll()->get(), 'validate_view'=>$candidate->find($id_candidate)->validate_view()]);
		    				break;
		    		} // switch
			    } else {
			    	return view("errors.page")->with(["type"=>"danger", "title"=>"Ошибка", "message"=>"Кандидат {$id_candidate} не найден."]);
			    }
		    } else {
		        switch ($id_candidate) {
					// Добавление
		        	case "add":
		    			return view("candidate_edit")->with(['regions'=>$base_region->getAll()->get(), 'elections'=>$election->getAll()->orderByDefault()->get(), 'activities'=>$activity->getAll()->get()]);
		        		break;
					// Печать
		        	case "print":
				        return view('candidates_print')->with(['regions'=>$base_region->getAll()->get(), "results"=>$candidate->getAll()->filter()->get(), "showFields"=>$candidate->getFieldsForShow(), 'params'=>Session::get('candidates')]);
		        		break;
		        	default:
		        		return redirect('/candidates');
		        		breask;

		        }
		    }
	    }
    }

    // Удаление кандидата
    public function deleteIndex(Candidate $candidate, Request $request) 
    {
    	$candidate->del($request->input('id'));
    	return redirect('/candidates');
    }


    // Обработка post запросов(добавление-изменение)
    public function postIndex(Candidate $candidate, Candidate_Comment $candidate_comment, Show_Field $show_field, Candidate_Activity $candidate_activity, Candidate_Election $candidate_election, Request $request)
    {
    	
    	switch ($request->input('action')) {
    		// Установка сортировки
    		case 'candidatesOrderBy':
    			$field = $show_field->where('name_table', 'candidates')->where('field', $request->input('field'))->first();
    			if ($field) {
    				$candidate->setOrderByField($field->order_by);
    			}
				return redirect("/candidates");
    			break;
    		// Установка фильтра
    		case 'setFilter':
    			$candidate->setFilter($request);
				return redirect("/candidates");
    			break;
    		// Сброс фильтра
    		case 'resetFilter':
    			$candidate->setFilter();
				return redirect("/candidates");
    			break;
			
			// Сохранение полей кандидата
			/*
			// 15.04.2016 Жук А.А. Отключено, перенесено в AjaxController.
			case 'saveCandidate':
				// Валидация
				$v = $candidate->validate($request);
				if ($v->fails()) {
					return redirect()->back()->withErrors($v->errors())->withInput($request->all());
				}    
				$id_candidate = $candidate->saveCandidate($request->all());
				// Округа
				$candidate_election->saveElections($id_candidate, $request->all());
				// Деятельности
				$candidate_activity->saveActivities($id_candidate, $request->all());
				return redirect("/candidates/{$id_candidate}/view");
				break;
			*/

			// Сохранение комментария
			case 'saveComment':
				// Валидация
				$v = $candidate_comment->validate($request);
				if ($v->fails()) {
					return redirect()->back()->withErrors($v->errors())->withInput($request->all());
				}    
				$candidate_comment->saveComment($request->all());
				return redirect("/candidates/{$request->input('id_candidate')}/view");
				break;
			// Установка полей просмотра
			case "setFieldsForShow":
				$candidate->setFieldsForShow($request);
				return redirect('/candidates');
				break;
		}
    }



}

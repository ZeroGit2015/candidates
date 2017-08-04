<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Expert;
use App\Expert_Href;
use App\Base_Region;
use App\Status;
use App\User;
use App\Show_Field;
use App\Expert_Activity;
use App\Activity;

use Auth;
use Session;

class ExpertsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Таблица, формы просмотра и редактирования
    public function getIndex(Expert $expert, Base_Region $base_region, Activity $activity, Status $statuses, User $user, Request $request, $id_expert= '', $operation = '')
    {
        if (!$id_expert) {
			// В случае, если query возвращает ошибку - сбрасываю фильтр
			try {
				$results = $expert->getAll()->get();
			} catch (\Exception $e) {
    			$expert->setFilter();
    			$expert->setOrderByField();

				$results = $expert->getAll()->get();
			}
	        return view('experts')->with(["results"=>$results, "showFields"=>$expert->getFieldsForShow(), 'regions'=>$base_region->getAll()->get(), 'activities'=>$activity->getAll()->get(), 'params'=>$user->getParams()]);
	    } else {
	    	if ((int)($id_expert)>0) {
	    		switch ($operation) {
		    		// Печать
		    		case 'print':
		    			return view("expert_print")->with(['data'=>$expert->find($id_expert), 'regions'=>$base_region->getAll()->get(), 'activities'=>$activity->getAll()->get(), 'statuses'=>$statuses->getAll('experts')->get()]);
		    		 	break;
		    		// Редактирование
		    		case 'edit':
		    			return view("expert_edit")->with(['data'=>$expert->find($id_expert), 'regions'=>$base_region->getAll()->get(), 'activities'=>$activity->getAll()->get(), 'statuses'=>$statuses->getAll('experts')->get()]);
		    		 	break;
					// Журнал
		        	case "log":
		    			return view("expert_log")->with(['data'=>$expert->find($id_expert)]);
		        		break;
		    		// Просмотр
		    		case 'view':
		    		default:
		    			return view("expert_view")->with(['data'=>$expert->find($id_expert), 'regions'=>$base_region->getAll()->get(), 'activities'=>$activity->getAll()->get(), 'statuses'=>$statuses->getAll('experts')->get()]);
		    			break;
		    	} // switch
		    } else {
		        switch ($id_expert) {
					// Добавление
		        	case "add":
		    			return view("expert_edit")->with(['regions'=>$base_region->getAll()->get(), 'activities'=>$activity->getAll()->get(), 'statuses'=>$statuses->getAll('experts')->get()]);
		        		break;
					// Печать
		        	case "print":
				        return view('experts_print')->with(["results"=>$expert->getAll()->filter()->get(), "showFields"=>$expert->getFieldsForShow(), 'regions'=>$base_region->getAll()->get(), 'activities'=>$activity->getAll()->get(), 'params'=>Session::get('experts')]);
		        		break;
		        	default:
		        		return redirect('/experts');
		        		breask;

		        }
		    }
	    }
    }

    // Удаление кандидата
    public function deleteIndex(Expert $expert, Request $request) 
    {
    	$expert->del($request->input('id'));
    	return redirect('/experts');
    }


    // Обработка post запросов(добавление-изменение)
    public function postIndex(Expert $expert, Expert_Href $expert_href, Show_Field $show_field, Expert_Activity $expert_activity, Request $request)
    {
    	
    	switch ($request->input('action')) {
    		// Установка сортировки
    		case 'expertsOrderBy':
    			$field = $show_field->where('name_table', 'experts')->where('field', $request->input('field'))->first();
    			if ($field) {
    				$expert->setOrderByField($field->order_by);
    			}
				return redirect("/experts");
    			break;
    		// Установка фильтра
    		case 'setFilter':
    			$expert->setFilter($request);
				return redirect("/experts");
    			break;
    		// Сброс фильтра
    		case 'resetFilter':
    			$expert->setFilter();
				return redirect("/experts");
    			break;
			// Сохранение полей кандидата
			case 'saveExpert':
				// Валидация
				$v = $expert->validate($request);
				if ($v->fails()) {
					return redirect()->back()->withErrors($v->errors())->withInput($request->all());
				}    
				$id_expert = $expert->saveExpert($request->all());
				// Деятельности
				$expert_activity->saveActivities($id_expert, $request->all());
				return redirect("/experts/{$id_expert}/view");
				break;
			// Сохранение комментария
			case 'saveHref':
				// Валидация
				$v = $expert_href->validate($request);
				if ($v->fails()) {
					return redirect()->back()->withErrors($v->errors())->withInput($request->all());
				}    
				$expert_href->saveHref($request->all());
				return redirect("/experts/{$request->input('id_expert')}/view");
				break;
			// Установка полей просмотра
			case "setFieldsForShow":
				$expert->setFieldsForShow($request);
				return redirect('/experts');
				break;
		}
    }



}

<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;
use Session;
use \App\Classes\A;
use App\Log;
use App\User;
use App\Show_Field;
use App\Candidate_Election;
use App\Status;
use App\Candidate_Activity;
use App\Election;
use App\Election_Okrug;
use App\Base_Region;


class Candidate extends Model
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

    protected $table="candidates";
	// Поля, которые не обновляются
	protected $guarded = ['id', 'updated_at', 'created_at'];


    // Список кандидатов
    public function getAll() 
    {
    	$orderBy = $this->getOrderByField();
		return $this->leftJoin('base_regions', 'base_regions.id', '=', 'candidates.id_region')->select('candidates.*')->filter()->orderByRaw("{$orderBy['name']} {$orderBy['type']}");
    }
	

	// Комментарии
	public function comments()
	{
		return $this->hasMany('App\Candidate_Comment', 'id_candidate', 'id');
	}


	// Журнал
	public function log()
	{   
		return Log::select(['*', DB::raw('created_at + INTERVAL 3 HOUR AS created_at_3')])->where('name_table', 'candidates')->where('id_table', $this->id)->orderBy('created_at', 'DESC')->get();
	}


    // Удаление кандидата
    public function del($id) 
    {
		$this->find($id)->delete();
    	Candidate_Comment::where('id_candidate', '=', $id)->delete();
    	Candidate_Activity::where('id_candidate', '=', $id)->delete();

    }
	
	
	// Валидация
	public function validate($request)
	{
		// Русификация имен полей для сообщений валидатора
		$attributeNames = array();
		foreach ($this->getFieldsList() as $field) {
			$attributeNames[$field] = $this->getFieldParams($field)->Comment;
		}

		$result = Validator::make($request->all(), [
        	'fio' => 'required',
    	]);
    	$result->setAttributeNames($attributeNames);

		return $result;

	}


	// Валидация, показываемая во вьюхе
	public function validate_view()
	{
		$result = [];
		if (count(explode(" ", $this->fio))<3) $result[] = "Отчество";
		if (!$this->id_region) $result[] = "Регион";
		if (!$this->job) $result[] = "Место работы";
		if (!$this->job_status) $result[] = "Должность";
		if (!$this->email) $result[] = "e-mail";
		if (!$this->phone) $result[] = "Телефон";
		if (!$this->invite) $result[] = "Инициатор внесения";
		return $result;
	}


	// Связь с выборами
	public function elections()
	{
		$result = array();
		if ($this->id) {
			$result = Candidate_Election::select('candidate_elections.*', 'elections.region', 'elections.group', 'elections.name')->where('candidate_elections.id_candidate', "=", $this->id)->leftJoin('elections', 'elections.id', "=", 'candidate_elections.id_election')->orderBy('elections.region', 'elections.group', 'elections.name')->get();
			foreach ($result AS $key=>$value) {
				$election = Election::find($value['id_election']);
			 	$result[$key]->election_name = $election->election_name;
			 	$result[$key]->have_okrugs = $election->have_okrugs;
			}
		}
		return $result;
	}


	// Связь с округами выборов
	// Возвращает все округа, если выбран - checked = 'checked'
	public function election_okrugs($id_election)
	{
		$result = array();

		$election = Election::find($id_election);
		if ($election->have_okrugs) {
			if ($this->id) {
				$election_okrug = New Election_Okrug();
    	    	$result = $election_okrug->getAll($id_election)->get();
    	    	foreach ($result AS $key=>$value) { $result[$key]['selected'] = ""; }
				$okrugs = Candidate_Election_Okrug::select('*')->where('id_candidate', "=", $this->id)->where('id_election', "=", $id_election);
				if ($okrugs->exists()) {
					foreach($okrugs->get() AS $okrug) {
						foreach ($result AS $key=>$value) {
							if ($okrug->id_election_okrug==$value->id) {
								$result[$key]['selected'] = 'selected';
							}
						}
					}
				}
			}
		}
		return $result;
	}


	// Связь с статусами выборов
	// Возвращает все статусы, если выбран - checked = 'checked'
	public function election_statuses($id_election)
	{
		$result = array();

		if ($this->id) {
			$status = New Status();
    		$result = $status->getAll('candidates', $id_election)->get();
    		foreach ($result AS $key=>$value) { $result[$key]['selected'] = ""; }
			$elections = Candidate_Election::select('*')->where('id_candidate', "=", $this->id)->where('id_election', "=", $id_election)->first();
			if ($elections->exists()) {
				foreach ($result AS $key=>$value) {
					if ($elections->id_status==$value->id) {
						$result[$key]['selected'] = 'selected';
					}
				}
			}
		}
		return $result;
	}


	// Связь с деятельностями
	public function activities()
	{
		$result = array();
		if ($this->id) {
			$result = Candidate_Activity::select('candidate_activities.*', 'activity.name', 'activity.detail')->where('candidate_activities.id_candidate', "=", $this->id)->leftJoin('activity', 'activity.id', "=", 'candidate_activities.id_activity')->orderBy('activity.name')->get();
		}
		return $result;
	}


	// Связь с регионом
	public function region()
	{
		return $this->hasOne('App\Base_Region', 'id', 'id_region');
	}
	

	// Проверка на дубль
	public function checkCandidate($inputs) 
	{
		$result = $this->select("*")->where("fio", "=", $inputs['fio'])->where("id", "!=", $inputs['id'])->first();
		return $result;
	}


	// Сохранение
	public function saveCandidate($inputs) 
	{
		if ($inputs['id'])  {
			$candidate = $this->find($inputs['id']);
		} else {
			$candidate = $this;
		}
		$fields = $this->getFieldsList();
		foreach ($fields AS $field) {
			if (isset($inputs[$field])) {
				switch ($field) {
					case "bdate":
						$candidate->$field = A::to_dt_mysql($inputs[$field]);
						break;
					default:
						$candidate->$field = $inputs[$field];
						break;
				} // switch
		    } else {
				$candidate->$field = "";
		    }
		}
		$candidate->save();
		return $candidate->id;
	}


	// Получение списка полей с признаками показа
	public function getFieldsForShow() 
	{
		$result = array();
		$params = User::getParams();
		if (isset($params['candidates']['fields']) and is_array($params['candidates']['fields'])) {
			foreach (Show_Field::getAll($this->table)->get() AS $key => $value) {
				$result[$value->field] = array(
					'id'      	=> $value->id,
					'name'      => $value->name,
					'field'     => $value->field,
					'order_by'  => $value->order_by,
					'visible'   => (isset($params['candidates']['fields'][$value->field]) and $params['candidates']['fields'][$value->field]),
				);
			}

		} else {
			
			foreach (Show_Field::getAll($this->table)->get() AS $key => $value) {
				$params['candidates']['fields'][$value->field] = $value['attributes']['visible'];
				$result[$value->field] = array(
					'id'		=> $value->id,
					'name'		=> $value->name,
					'field'		=> $value->field,
					'order_by'  => $value->order_by,
					'visible'	=> $value['attributes']['visible'],
				);
				
			}
			$this->setOrderByField();
			User::setParams($params);
		}
		return $result;
	}


	// Сохранение списка полей с признаками показа
	public function setFieldsForShow($request) 
	{

		$params = User::getParams();
    
    	foreach (Show_Field::getAll($this->table)->get() AS $key => $value) {
			$params['candidates']['fields'][$value->field] = $request->input($value->field);
		}
		User::setParams($params);
	}


	// Чтение установок текущей сортировки
	public function getOrderByField() 
	{
		$params = User::getParams();
		if (!isset($params['candidates']['order_by'])) {
			$params = $this->setOrderByField();
		}
		$result = $params['candidates']['order_by'];
		return $result;
	}


	// Установка сортировки по полю
	public function setOrderByField($field=FALSE) 
	{
		if (!$field) $field="{$this->table}.id";

		$params = User::getParams();
		
		$type='asc';
		if (@$params['candidates']['order_by']['name']==$field) {
			if ($params['candidates']['order_by']['type']=='asc') {
				$type = 'desc';
			} else {
				$type = 'asc';
			}
		}
		
		$params['candidates']['order_by']['name'] = $field;
		$params['candidates']['order_by']['type'] = $type;
		User::setParams($params);
		return $params;
	}


	// Фильтры по установленным условиям
	public function scopeFilter($query) 
	{
		$result = $query;
		$params = User::getParams();
		if (!isset($params['candidates']['filters'])) {
			$params['candidates']['filters'] = [];
			User::setParams($params);
		}

		$whereRaw = "";
		foreach ($params['candidates']['filters'] as $key => $value) {
				if ($value['active']) {
					$whereRaw .= ($whereRaw ? "AND" : ""). " ({$value['operation']}) ";
				}
		}
		if ($whereRaw)	$result = $result->whereRaw($whereRaw);
		//dd($whereRaw);
		return $result;
	}


	// Установка фильтра по условиям
	public function setFilter($request = FALSE) 
	{
		$params = User::getParams();

		if ($request) {
			$arr_inputs  = $request->all();
			$arr_filters = array();
			foreach ($arr_inputs AS $key => $value) {
				switch ($key) {

				    // Кроме архивных выборов(актуальные выборы + не привязанные кандидаты)
				    case "actual_elections_only":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`id` IN (SELECT ce.`id_candidate` FROM `candidate_elections` ce LEFT JOIN `elections` e ON e.`id`=ce.`id_election` WHERE DATEDIFF(CURDATE(), e.`dt`)<=30) OR `candidates`.`id` NOT IN (SELECT ce.`id_candidate` FROM `candidate_elections` ce)",
								"value" 	=> $value,
								"name" 		=> "Кроме архивных выборов",
							);
						}
				    	break;
				    // Не полностью заполненные
				    case "not_full_data":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`fio` NOT LIKE '% % %' OR `candidates`.`id_region`=0 OR `candidates`.`job`='' OR `candidates`.`job_status`='' OR `candidates`.`email`='' OR `candidates`.`phone`='' OR `candidates`.`invite`='' ",
								"value" 	=> $value,
								"name" 		=> "Не полностью заполнены данные",
							);
						}
				    	break;

				    // Куратор
				    case "kurator":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`base_regions`.`kurator` ='{$value}'",
								"value" 	=> $value,
								"name" 		=> "Куратор = {$value}",
							);
						}
						break;

					// Проверка наличия значения в поле
					case "is_not_empty":
						if (is_array($value)) {
							$operation = "";
							$info = array();
							foreach ($value as $field) {
								switch ($field) {
									default:
										$operation .= ($operation ? "AND" : "")." `{$field}`!='' ";
										$info[] = $this->getFieldParams($field)->Comment;
										break;
								} // switch
							}
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "({$operation})",
								"value" 	=> $value,
								"name" 		=> "Непустые поля: ".implode(", ", $info),
							);	
						}
						break;
					// Проверка отсутствия значения в поле
					case "is_empty":
						if (is_array($value)) {
							$operation = "";
							$info = array();
							foreach ($value as $field) {
								switch ($field) {
									default:
										$operation .= ($operation ? "AND" : "")." (`{$field}`='' OR ISNULL(`{$field}`)=1) ";
										$info[] = $this->getFieldParams($field)->Comment;
										break;
								} // switch
							}
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "({$operation})",
								"value" 	=> $value,
								"name" 		=> "Пустые поля: ".implode(", ", $info),
							);	
						}
						break;
					// Поиск по полю
					case "search":
						if ($arr_inputs['value']) {
							$arr_filters[$key] = array(
								"active"	=> FALSE,
								"value" 	=> $value,
							);
							switch ($value) {
								// По фамилии
								case "fio":
									$arr_filters['value'] = array(
										"active"	=> TRUE,
										"operation" => "`fio` LIKE '%{$arr_inputs['value']}%'",
										"value" 	=> $arr_inputs['value'],
										"name" 		=> "Ф.И.О. содержит {$arr_inputs['value']}",
									);	
									break;
								// По всем полям	
								case "all":
									$fields = $this->getFieldsList();
									$operation = "";
									foreach ($fields AS $field) {
										// При операции поле date LIKE %киррилица% вылазит ошибка, проверяю тип входных данных
										if (!(preg_match("/[а-яА-Я]+/", $arr_inputs['value']) and $this->getFieldParams($field)->Type=='date')) {
											$operation .= ($operation ? "OR" : "")." `{$field}` LIKE '%{$arr_inputs['value']}%' ";
										}
									}
									$arr_filters['value'] = array(
										"active"	=> TRUE,
										"operation" => "({$operation})",
										"value" 	=> $arr_inputs['value'],
										"name" 		=> "Любое поле содержит {$arr_inputs['value']}",
									);	
									break;
							} // switch
						}
						break;
					// Регион
					case "id_region":
						if ($value) {
						    $region = Base_Region::find($value);
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`id_region` = '{$value}'",
								"value" 	=> $value,
								"name" 		=> "Регион = {$region->name}",
							);
						}
						break;
					// Деятельность
					case "activity":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`id` IN (SELECT DISTINCT o.`id_candidate` FROM `candidate_activities` o WHERE o.`id_activity`= '{$value}')",
								"value" 	=> $value,
								"name" 		=> "Деятельность = {$value}",
							);
						}
						break;
					// Выборы: Регион
					case "election_region":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`id` IN (SELECT DISTINCT o.`id_candidate` FROM `candidate_elections` o WHERE o.`id_election` IN (SELECT `id` FROM `elections` WHERE `region`='{$value}'))",
								"value" 	=> $value,
								"name" 		=> "Выборы: Регион = {$value}",
							);
						}
						break;
					// Выборы: Группировка
					case "election_group":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`id` IN (SELECT DISTINCT o.`id_candidate` FROM `candidate_elections` o WHERE o.`id_election` IN (SELECT `id` FROM `elections` WHERE `group`='{$value}'))",
								"value" 	=> $value,
								"name" 		=> "Выборы: Группировка = {$value}",
							);
						}
						break;
					// Выборы: Наименование
					case "election_name":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`id` IN (SELECT DISTINCT o.`id_candidate` FROM `candidate_elections` o WHERE o.`id_election` IN (SELECT `id` FROM `elections` WHERE `name`='{$value}'))",
								"value" 	=> $value,
								"name" 		=> "Выборы: Наименование = {$value}",
							);
						}
						break;
					// Выборы: Статус
					case "election_status":
						if ($value) {
						    $status = Status::find($value);
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`candidates`.`id` IN (SELECT DISTINCT o.`id_candidate` FROM `candidate_elections` o WHERE o.`id_status`='{$value}')",
								"value" 	=> $value,
								"name" 		=> "Выборы: Статус = {$status->name}",
							);
						}
						break;
				} // switch
			} // foreach
			$params['candidates']['filters'] = $arr_filters;
		} else {
			// Сброс фильтра
			$params['candidates']['filters']	= [];
		}
		User::setParams($params);
	}

}



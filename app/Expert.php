<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;

use App\Log;
use App\User;
use App\Show_Field;
use App\Status;
use App\Expert_Activity;

use Session;
use \App\Classes\A;


class Expert extends Model
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

    protected $table = 'experts';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'created_at', 'updated_at'];


    // Список кандидатов
    public function getAll() 
    {
    	$orderBy = $this->getOrderByField();

		return $this->leftJoin('base_regions', 'base_regions.id', '=', 'experts.id_region')->select('experts.*', 'base_regions.name')->filter()->orderByRaw("{$orderBy['name']} {$orderBy['type']}");
    }
	


	// Журнал
	public function log()
	{   
		return Log::select(['*', DB::raw('created_at + INTERVAL 3 HOUR AS created_at_3')])->where('name_table', 'experts')->where('id_table', $this->id)->orderBy('created_at', 'DESC')->get();
	}


    // Удаление Эксперта
    public function del($id) 
    {
		$this->find($id)->delete();
    	Expert_Href::where('id_expert', '=', $id)->delete();
    	Expert_Activity::where('id_expert', '=', $id)->delete();

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


	// Связь с деятельностями
	public function activities()
	{
		$result = array();
		if ($this->id) {
			$result = Expert_Activity::select('expert_activities.*', 'activity.name', 'activity.detail')->where('expert_activities.id_expert', "=", $this->id)->leftJoin('activity', 'activity.id', "=", 'expert_activities.id_activity')->orderBy('activity.name')->get();
		}
		return $result;
	}

	// Связь с регионом
	public function region()
	{
		return $this->hasOne('App\Base_Region', 'id', 'id_region');
	}

	// Связь со статусом
	public function status()
	{
		return Status::select('*')->where('name_table', 'experts')->where('id', "=", $this->id_status)->first();
	}
	

	// Сохранение
	public function saveExpert($inputs) 
	{
		if ($inputs['id'])  {
			$expert = $this->find($inputs['id']);
		} else {
			$expert = $this;
		}
		$fields = $this->getFieldsList();
		foreach ($fields AS $field) {
			if (isset($inputs[$field])) {
				switch ($field) {
					case "bdate":
						$expert->$field = A::to_dt_mysql($inputs[$field]);
						break;
					default:
						$expert->$field = $inputs[$field];
						break;
				} // switch
		    } else {
				$expert->$field = "";
		    }
		}
		$expert->save();
		return $expert->id;
	}


	// Получение списка полей с признаками показа
	public function getFieldsForShow() 
	{
		$result = array();
		$params = User::getParams();
		if (isset($params['experts']['fields']) and is_array($params['experts']['fields'])) {
			foreach (Show_Field::getAll($this->table)->get() AS $key => $value) {
				$result[$value->field] = array(
					'id'      	=> $value->id,
					'name'      => $value->name,
					'field'     => $value->field,
					'order_by'  => $value->order_by,
					'visible'   => (isset($params['experts']['fields'][$value->field]) and $params['experts']['fields'][$value->field]),
				);
			}

		} else {
			
			foreach (Show_Field::getAll($this->table)->get() AS $key => $value) {
				$params['experts']['fields'][$value->field] = $value['attributes']['visible'];
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
			$params['experts']['fields'][$value->field] = $request->input($value->field);
		}
		User::setParams($params);
	}

	// Чтение установок текущей сортировки
	public function getOrderByField() 
	{
		$params = User::getParams();
		if (!isset($params['experts']['order_by'])) {
			$params = $this->setOrderByField();
		}
		$result = $params['experts']['order_by'];
		return $result;
	}

	// Установка сортировки по полю
	public function setOrderByField($field=FALSE) 
	{
		if (!$field) $field="{$this->table}.id";

		$params = User::getParams();
		
		$type='asc';
		if (@$params['experts']['order_by']['name']==$field) {
			if ($params['experts']['order_by']['type']=='asc') {
				$type = 'desc';
			} else {
				$type = 'asc';
			}
		}
		
		$params['experts']['order_by']['name'] = $field;
		$params['experts']['order_by']['type'] = $type;
		User::setParams($params);
	}

	// Фильтры по установленным условиям
	public function scopeFilter($query) 
	{
		$result = $query;
		$params = User::getParams();
		if (!isset($params['experts']['filters'])) {
			$params['experts']['filters'] = [];
			User::setParams($params);
		}

		$whereRaw = "";
		foreach ($params['experts']['filters'] as $key => $value) {
				if ($value['active']) {
					$whereRaw .= ($whereRaw ? "AND" : ""). " {$value['operation']} ";
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
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`id_region` = '{$value}'",
								"value" 	=> $value,
								"name" 		=> "Код региона = {$value}",
							);
						}
						break;
					// Деятельность
					case "activity":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`experts`.`id` IN (SELECT DISTINCT o.`id_expert` FROM `expert_activities` o WHERE o.`id_activity`= '{$value}')",
								"value" 	=> $value,
								"name" 		=> "Деятельность = {$value}",
							);
						}
						break;
				} // switch
			} // foreach
			$params['experts']['filters'] = $arr_filters;
		} else {
			// Сброс фильтра
			$params['experts']['filters']	= [];
		}
		User::setParams($params);
	}


	// Ссылки на статьи и др. материалы
	public function hrefs()
	{
		return $this->hasMany('App\Expert_Href', 'id_expert', 'id');
	}


}

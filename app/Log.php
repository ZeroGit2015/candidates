<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Log extends Model
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

    protected $table = 'logs';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'created_at', 'updated_at'];
	// Количество записей на странице
	private $page_size = 30;

    // Добавление записи в журнал
    public function saveLog($user, $name_table, $information, $id_table)
    {
		$id_user  = $user ? $user->id : 0;
		$id_table = $id_table ? $id_table : 0;

        $this->create([
			'id_user'     => $id_user,
            'id_table'    => $id_table,
            'name_table'  => $name_table,
            'information' => $information,
        ]);
    }


    // Список 
    public function getAll() 
    {
        $result = $this->select(['*', DB::raw('created_at + INTERVAL 3 HOUR AS created_at_3')])->where("id_table", "!=", "0")->filter()->orderBy("created_at", "DESC")->paginate($this->page_size);
   		return $result;
	}


	// Связь с таблицей
	public function item_table()
	{
		$query = "
					SELECT
						*
					FROM
						`{$this->name_table}`
					WHERE
						`id` = '{$this->id_table}'
		";
		return DB::selectOne($query);
	}	


	// Связь с пользователем
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'id_user');
	}	


	// Фильтры по установленным условиям
	public function scopeFilter($query) 
	{
		$result = $query;
		$params = User::getParams();
		if (!isset($params['logs']['filters'])) {
			$params['logs']['filters'] = [];
			User::setParams($params);
		}

		$whereRaw = "";
		foreach ($params['logs']['filters'] as $key => $value) {
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
					// Поиск по полю
					case "search":
						if ($arr_inputs['value']) {
							$arr_filters[$key] = array(
								"active"	=> FALSE,
								"value" 	=> $value,
							);
							switch ($value) {
								// По id_table
								case "experts.id":
								case "candidates.id":
									$arr_filters['value'] = array(
										"active"	=> TRUE,
										"operation" => "`id_table` ='{$arr_inputs['value']}' AND `name_table`='".explode(".", $value)[0]."'",
										"value" 	=> $arr_inputs['value'],
										"name" 		=> "{$value} = {$arr_inputs['value']}",
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
					// Юзер
					case "id_user":
						if ($value) {
							$arr_filters[$key] = array(
								"active"	=> TRUE,
								"operation" => "`id_user` = '{$value}'",
								"value" 	=> $value,
								"name" 		=> "Пользователь = {$value}",
							);
						}
						break;
				} // switch
			} // foreach
			$params['logs']['filters'] = $arr_filters;
		} else {
			// Сброс фильтра
			$params['logs']['filters']	= [];
		}
		User::setParams($params);
	}

}

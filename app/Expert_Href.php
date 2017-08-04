<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class Expert_Href extends Model
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

    protected $table = 'expert_hrefs';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'created_at', 'updated_at'];
	

	// Связь с пользователем
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'id_user');
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
        	'title'     => 'required',
        	'id_expert' => 'required',
    	]);
    	$result->setAttributeNames($attributeNames);

		return $result;

	}


	// Сохранение
	public function saveHref($inputs) 
	{
		if ($inputs['id'])  {
			$href = $this->find($inputs['id']);
		} else {
			$href = $this;
		}

		$fields = $this->getFieldsList();
		foreach ($fields AS $field) {
			if (isset($inputs[$field])) {
				$href->$field = $inputs[$field];
		    } else {
				$href->$field = "";
		    }
		}
		$href->id_user = Auth::user()->id;
		$href->save();
		return $href->id;
		
	}
}

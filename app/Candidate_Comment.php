<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class Candidate_Comment extends Model
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

    protected $table = 'candidate_comments';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'updated_at', 'created_at'];
	

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
        	'comment' 	   => 'required',
        	'id_candidate' => 'required',
    	]);
    	$result->setAttributeNames($attributeNames);

		return $result;

	}


	// Сохранение
	public function saveComment($inputs) 
	{
		if ($inputs['id'])  {
			$comment = $this->find($inputs['id']);
		} else {
			$comment = $this;
		}

		$fields = $this->getFieldsList();
		foreach ($fields AS $field) {
			if (isset($inputs[$field])) {
				$comment->$field = $inputs[$field];
		    } else {
				$comment->$field = "";
		    }
		}
		$comment->id_user = Auth::user()->id;
		$comment->save();
		return $comment->id;
		
	}
}

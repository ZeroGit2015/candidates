<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Status;

class Election extends Model
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

    protected $table = 'elections';
	// Поля, которые не обновляются
	protected $guarded = ['id', 'created_at', 'updated_at'];
	// Количество записей на странице
	private $page_size = 30;
	// Добавляет несуществующий атрибут election_name во всем выборки
	protected $appends = ['election_name'];


    // Список 
    public function getAll() 
    {
		$result = $this->select('elections.*');
   		return $result;
	}
	
	// Сортировка по умолчанию
	public function scopeOrderByDefault($query) {
		$result = $query->orderBy("elections.region", "elections.group", "elections.name");
		return $result;
	}

	// Вернуть "сборное" наименование (mutator)
	public function getElectionNameAttribute($value) 
	{
		$result  = ($this->region and $this->region!='-') ? $this->region : "";
		$result .= ($result and $this->group and $this->group!='-') ? " - " : "";
		$result .= ($this->group and $this->group!='-') ? "{$this->group}" : "";
		$result .= ($result and $this->name and $this->name!='-') ? " - " : "";
		$result .= ($this->name and $this->name!='-') ? "{$this->name}" : "";
		return $result;
	}

    // Список регионов
    public function getRegions() 
    {
		$result = $this->getAll()->groupBy('region')->orderBy("region");
   		return $result;
	}
	
    // Список групп
    public function getGroups($region="") 
    {
		$result = $this->select("group")->where('region', '=', $region)->groupby('group')->orderby("group");
   		return $result;
	}

    // Список наименований
    public function getNames($region="", $group="") 
    {
    	$result = $this->select("name")->where('region', '=', $region);
    	if (!is_null($group)) {
    		$result = $result->where('group', '=', $group);
    	}
		$result = $result->groupby('name')->orderby("name");
   		return $result;
	}

    // Список статусов
    public function getStatuses($region="", $group="", $name="") 
    {
    	$result = FALSE;
    	$elections = $this->where('region', '=', $region);
    	if (!is_null($group)) {
    		$elections = $elections->where('group', '=', $group);
    	}
    	if (!is_null($name)) {
    		$elections = $elections->where('name', '=', $name);
    	}
		$elections = $elections->get()->toArray();
		$statuses = New Status();
		$result = $statuses->getAll("candidates")->whereIn("id_election", $elections)->orderBy("name");

   		return $result;
	}

}

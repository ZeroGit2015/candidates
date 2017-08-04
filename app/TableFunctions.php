<?php

namespace App;

use DB;

trait TableFunctions
{


	// ������ ����� �������
	public function getFieldsList($all = FALSE)
	{   
		$result = []; 
		$fields = DB::getSchemaBuilder()->getColumnListing($this->table);
		foreach ($fields as $key => $value) {
			if (!in_array($value, $this->guarded) or $all) {
				$result[] = $value;
			}
		} 
		return $result;
	}


	// ���������� ��������� ����
	public function getFieldParams($field)
	{
		$query = "
					SHOW 
						FULL COLUMNS 
					FROM 
						{$this->table} 
					WHERE 
						`Field` = '{$field}'
		";
		return DB::selectOne($query);
	}
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Candidate;

class CandidateTableSeeder extends Seeder {

	public function run()
	{
			DB::table('candidates')->truncate();
			Candidate::create([
 				'fio'			=> 'Тест Тестович Тестов',
 				'city'			=> 'Москва',
 				'information'	=> 'Справка',
 				'notice'		=> 'Примечания',
 				'id_status'		=> '0',
 			]);

		
	}

}
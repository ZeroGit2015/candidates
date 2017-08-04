<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Election;

class ElectionTableSeeder extends Seeder {

	public function run()
	{
			DB::table('elections')->truncate();
			Election::create([
 				'region'		=> 'Москва',
 				'group'			=> 'ЦАО',
 				'name'			=> 'Пресненский',
 				'have_okrugs'	=> 1,
 				'dt'			=> "2016-09-01",
 			]);

		
	}

}
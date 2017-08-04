<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class ElectionOkrugTableSeeder extends Seeder {

	public function run()
	{
			DB::table('election_okrugs')->truncate();
			DB::table('election_okrugs')->insert([
				[
 					'id_election'	=> '1',
 					'name'			=> 'Округ 1',
	 			],
				[
 					'id_election'	=> '1',
 					'name'			=> 'Округ 2',
	 			]
 			]);

		
	}

}
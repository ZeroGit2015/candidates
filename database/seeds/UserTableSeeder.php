<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;

class UserTableSeeder extends Seeder {

	public function run()
	{
			DB::table('users')->truncate();

			User::create([
 				'name'			=> 'Admin',
 				'email'			=> 'allzero@mail.by',
 				'password'		=> '******',
 			]);

		
	}

}
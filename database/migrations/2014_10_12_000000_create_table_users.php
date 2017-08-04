<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;


class CreateTableUsers extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('users')) {
			Schema::create('users', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();
				$table->rememberToken();
		
				$table->string('name')->comment = "Ф.И.О.";
				$table->string('email')->unique()->comment = "email";
				$table->string('password')->comment = "Пароль";
				$table->longText('params')->comment = "Технические параметры";
				$table->integer('role')->default(0)->comment = "Роль";
		
			});
			// Юзер по-умолчанию
	        DB::table('users')->insert(
    	    	[
 					'name'			=> 'Admin',
 					'email'			=> 'allzero@tut.by',
 					'password'		=> Hash::make('111111'),
	 			]        
 			);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}
}

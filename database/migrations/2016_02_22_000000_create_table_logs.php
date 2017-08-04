<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogs extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('logs')) {
			Schema::create('logs', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();

				$table->integer('id_user')->comment = "Связь с пользователем";
				$table->string('name_table', 60)->comment = "Наименование таблицы";
				$table->integer('id_table')->comment = "Значение id таблицы";
				$table->text('information')->comment = "Информация";
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}

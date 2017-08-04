<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStatuses extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('statuses')) {
			Schema::create('statuses', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";

	            $table->integer('id_election')->index()->comment = "Ссылка на выборы";
				$table->text('name')->comment = 'Наименование';
				$table->string('name_table', 100)->comment = 'Таблица';
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
		Schema::dropIfExists('statuses');
	}
}

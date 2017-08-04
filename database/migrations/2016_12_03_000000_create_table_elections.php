<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableElections extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('elections')) {
			Schema::create('elections', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();

				$table->date('dt')->index()->comment = "Дата";
				$table->string('region', 200)->index()->comment = "Регион";
				$table->string('group', 200)->index()->comment = "Группа";
				$table->string('name', 200)->index()->comment = "Наименование";
				$table->integer('have_okrugs')->index()->default(0)->comment = "Наличие одномандатных округов(1-да,0-нет)";
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
		Schema::drop('elections');
	}
}

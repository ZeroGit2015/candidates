<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableElectionOkrugs extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('election_okrugs')) {
			Schema::create('election_okrugs', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();

				$table->string('name', 255)->comment = "Наименование";
				$table->string('detail', 2765)->comment = "Детали";
	            $table->integer('id_election')->index()->comment = "Ссылка на выборы";
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
		Schema::drop('election_okrugs');
	}
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCandidateActivities extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('candidate_activities')) {
			Schema::create('candidate_activities', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();

				$table->integer('id_activity')->comment = "Ссылка на деятельность";
				$table->integer('id_candidate')->comment = "Ссылка на кандидата";
				// Ключ
				$table->unique(array('id_candidate', 'id_activity'));
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
		Schema::drop('candidate_activities');
	}
}

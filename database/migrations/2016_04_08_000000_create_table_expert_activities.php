<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpertActivities extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('expert_activities')) {
			Schema::create('expert_activities', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();

				$table->integer('id_activity')->comment = "Ссылка на деятельность";
				$table->integer('id_expert')->comment = "Ссылка на эксперта";
				// Ключ
				$table->unique(array('id_expert', 'id_activity'));
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
		Schema::drop('expert_activities');
	}
}

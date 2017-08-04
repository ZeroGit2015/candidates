<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpertHrefs extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('expert_hrefs')) {
			Schema::create('expert_hrefs', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();

				$table->integer('id_expert')->comment = "Ссылка на эксперта";
				$table->integer('id_user')->comment = "Пользователь, создавший ссылку";
				$table->string('title', 600)->comment = "Наименование ссылки";
				$table->string('href', 600)->comment = "Ссылка";
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
		Schema::drop('expert_hrefs');
	}
}

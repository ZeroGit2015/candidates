<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCandidateComments extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('candidate_comments')) {
			Schema::create('candidate_comments', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->integer('id_user')->comment = "Пользователь, создавший комментарий";
				$table->integer('id_candidate')->comment = "Ссылка на кандидата";
				$table->text('comment')->comment = "Текст комментария";
				$table->timestamps();
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
		Schema::drop('candidate_comments');
	}
}

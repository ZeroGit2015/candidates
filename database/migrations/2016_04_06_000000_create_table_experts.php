<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExperts extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('experts')) {
			Schema::create('experts', function (Blueprint $table) {
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();
	    
				$table->string('fio', 100)->comment = 'Ф.И.О.';
				$table->string('sex', 1)->comment = 'Пол';
				$table->date('bdate')->comment = 'Дата рождения';
				$table->string('job', 200)->comment = 'Работа';
				$table->string('job_status', 200)->comment = 'Должность';
				$table->text('web_organizations')->comment = 'Веб организации';
	    
				$table->string('vk_acc', 200)->comment = "Аккаунт вКонтакте";
				$table->string('fb_acc', 200)->comment = "Аккаунт Facebook";
				$table->string('ok_acc', 200)->comment = "Аккаунт Одноклассники";
				$table->string('tw_acc', 200)->comment = "Аккаунт Twitter";
				$table->string('lj_acc', 200)->comment = "Аккаунт LiveJournal";
				$table->string('inst_acc', 200)->comment = "Аккаунт Instagram";
				$table->string('per_acc', 200)->comment = "Аккаунт Periscope";
				$table->string('yt_acc', 200)->comment = "Аккаунт YouTube";
				$table->string('personal_site', 200)->comment = "Личный сайт";
				$table->string('wiki', 200)->comment = "Википедия";
	    
				$table->string('post_index', 200)->comment = "Почтовый индекс";
				$table->integer('id_region')->comment = "Регион(base_regions.id)";
				$table->string('post_address', 600)->comment = "Почтовый адрес";
	    
				$table->string('phone', 30)->comment = "Телефон";
				$table->string('email', 30)->comment = "email";
				$table->integer('id_status')->comment = "Статус";
	    
				$table->text('speaker_info')->comment = "Информация о ходе переговоров";
				$table->text('notice')->comment = "Примечание";
	    
				$table->text('information')->comment = "Справка";
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
		Schema::drop('experts');
	}
}

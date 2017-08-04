<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCandidates extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('candidates')) {
			Schema::create('candidates', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
				$table->timestamps();
    
				$table->string('fio', 100)->comment = 'Ф.И.О.';
                $table->integer('id_region')->comment = "Регион(base_regions.id)";
				$table->string('city', 60)->comment = 'Населенный пункт';
				
				$table->text('information')->comment = 'Справка';

				$table->string('email')->comment = "Email";
				$table->string('phone')->comment = "Телефон";
    
				$table->string('invite')->comment = "Инициатор внесения";
				
				$table->string('vk_acc')->comment = "Аккаунт вКонтакте";
				$table->string('fb_acc')->comment = "Аккаунт Facebook";
				$table->string('ok_acc')->comment = "Аккаунт Одноклассники";
				$table->string('tw_acc')->comment = "Аккаунт Twitter";
				$table->string('lj_acc')->comment = "Аккаунт LiveJournal";
				$table->string('inst_acc')->comment = "Аккаунт Instagram";
				$table->string('per_acc')->comment = "Аккаунт Periscope";
				$table->string('yt_acc')->comment = "Аккаунт YouTube";
				$table->string('personal_site')->comment = "Личный сайт";
				$table->string('wiki')->comment = "Википедия";
				
							
				$table->string('job')->comment = "Место работы";
				$table->string('job_status')->comment = "Должность";
    
				$table->boolean('vip')->comment = "VIP";
				$table->boolean('party')->comment = "Партийность";
				$table->integer('id_eparty')->comment = "id ЭП";
				$table->date('bdate')->comment("День рождения");

				$table->text('ups')->comment = "УПС";
				$table->text('auy')->comment = "ЭАУ";
				$table->text('urs')->comment = "УРС";
				$table->text('uv')->comment  = "УВ";
				
				$table->string('address', 400)->comment = 'Адрес';

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
		Schema::drop('candidates');
		Schema::drop('candidate_comments');
	}
}

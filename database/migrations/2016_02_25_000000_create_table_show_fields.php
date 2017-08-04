<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShowFields extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		if (!Schema::hasTable('show_fields')) {
			Schema::create('show_fields', function (Blueprint $table) {
				$table->engine = "MyISAM";
				$table->increments('id')->comment = "Ключ";
		
				$table->string('name_table', 100)->comment = 'Таблица';
				$table->string('field', 100)->comment = 'Поле(Псевдоним)';
				$table->integer('visible')->comment = 'Видимость по умолчанию';
				$table->text('name')->comment = 'Наименование столбца';
				$table->integer('order')->comment = 'Сортировка';
				$table->string('order_by', 255)->comment = 'Поле для сортировки по столбцу';
				$table->integer('active')->default(1)->comment = 'Признак использования';
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
		Schema::dropIfExists('show_fields');
	}
}

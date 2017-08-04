<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCandidateElections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		if (!Schema::hasTable('candidate_elections')) {
	        Schema::create('candidate_elections', function (Blueprint $table) {
				$table->engine = "MyISAM";
    	        $table->increments('id')->comment = "Ключ";
        	    $table->timestamps();

	            $table->integer('id_election')->index()->comment = "Ссылка на выборы";
    	        $table->integer('id_candidate')->index()->comment = "Ссылка на кандидата";
    	        $table->string('list_position',200)->comment = "Позиция в списке";

				$table->integer('id_status')->comment = "Статус";
				$table->text('speaker')->comment = "Ответственный за ведение переговоров от Яблока";
				$table->text('speaker_info')->comment = "Информация о ходе переговоров";
				$table->text('speaker_itog')->comment = "Итог переговоров";
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
        Schema::drop('candidate_elections');
    }
}

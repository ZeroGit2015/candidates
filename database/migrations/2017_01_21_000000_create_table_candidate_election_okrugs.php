<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCandidateElectionOkrugs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		if (!Schema::hasTable('candidate_election_okrugs')) {
	        Schema::create('candidate_election_okrugs', function (Blueprint $table) {
				$table->engine = "MyISAM";
    	        $table->increments('id')->comment = "Ключ";
        	    $table->timestamps();

    	        $table->integer('id_candidate')->index()->comment = "Ссылка на кандидата";
	            $table->integer('id_election')->index()->comment = "Ссылка на выборы";
	            $table->integer('id_election_okrug')->index()->comment = "Ссылка на одномандатный округ";
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
        Schema::drop('candidate_election_okrugs');
    }
}

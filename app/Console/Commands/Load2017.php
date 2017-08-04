<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Schema;


class Load2017 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load2017';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LOAD DATA from *_2017';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $db      = "inline";
        
    	$this->comment("candidates_2017");

    	if (Schema::hasColumn('candidates', 'old_id')) {
        	DB::statement(DB::raw("DELETE FROM `{$db}`.`candidate_elections` WHERE `id_candidate` IN (SELECT `id` FROM `{$db}`.`candidates` WHERE `old_id` !=0)"));
        	DB::statement(DB::raw("DELETE FROM `{$db}`.`candidates` WHERE `old_id` !=0"));
    	} else {
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `old_id` INT(9) DEFAULT 0"));
    	}


        $candidates2017 = DB::select("SELECT * FROM `{$db}`.`candidates_2017`");
        $candidate = [];
        foreach ($candidates2017 AS $candidate2017) {
    		$this->comment(" {$candidate2017->id}");
         	foreach ($candidate2017 AS $key=>$value) {
				switch ($key) {
					case "gd_in_list":
					case "regparlament":
					case "state_cap":
					case "other_omsu":
						break;
					case "id":
						$candidate[$key] = 0;
						$candidate["old_id"] = $value;
						break;
					default:
						$candidate[$key] = $value;
						break;
				} // switch
			} // foreach
			DB::table("{$db}.candidates")->insert($candidate);
        }
   		$this->comment("ok");

    	$this->comment("candidate_elections_2017");
        DB::statement(DB::raw("INSERT INTO `{$db}`.`candidate_elections` (`id_election`, `id_candidate`, `list_position`) SELECT ce.`id_election`+1 AS `id_election`, (SELECT c.`id` FROM `candidates` c WHERE c.`old_id`=ce.`id_candidate`) AS `id_candidate`, '' AS `list_position` FROM `{$db}`.`candidate_elections_2017` ce"));
   		$this->comment("ok");

    }
}

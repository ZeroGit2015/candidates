<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Schema;

class Update2016 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update2016';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UPDATE DATA from inline2016';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $db_2016 = "inline2016";
        $db      = "inline";

        $this->comment($this->description);
    	if (!Schema::hasColumn('candidates', 'party')) {
	    	$this->comment("party: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `party` tinyint(1) DEFAULT 0"));
    	}

    	if (!Schema::hasColumn('candidates', 'id_eparty')) {
	    	$this->comment("id_eparty: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `id_eparty` INT(11) DEFAULT 0"));
    	}

    	if (!Schema::hasColumn('candidates', 'id_region')) {
	    	$this->comment("id_region: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `id_region` INT(11) DEFAULT 0"));
    	}

    	$this->comment("candidates");
        $candidates2016 = DB::select("SELECT * FROM `{$db_2016}`.`candidates`");
        $candidate = [];
        foreach ($candidates2016 AS $candidate2016) {
    		$this->comment(" {$candidate2016->id}");
         	foreach ($candidate2016 AS $key=>$value) {
				switch ($key) {
					case "id_region":
					case "party":
					case "id_eparty":
						$candidate[$key] = $value;
						break;
					default:
						break;
				} // switch
			} // foreach
			DB::table("{$db}.candidates")->where("id", "=", $candidate2016->id)->update($candidate);
        }
   		$this->comment("ok");

    }
}

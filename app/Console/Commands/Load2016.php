<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Load2016 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load2016';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MOVE DATA from inline2016';

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
    	$this->comment("activity");
        DB::statement(DB::raw("DROP TABLE IF EXISTS `{$db}`.`activity`"));
        DB::statement(DB::raw("CREATE TABLE `{$db}`.`activity` LIKE `{$db_2016}`.`activity`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`activity` SELECT * FROM `{$db_2016}`.`activity`"));
         
    	$this->comment("base_regions");
        DB::statement(DB::raw("DROP TABLE IF EXISTS `{$db}`.`base_regions`"));
        DB::statement(DB::raw("CREATE TABLE `{$db}`.`base_regions` LIKE `{$db_2016}`.`base_regions`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`base_regions` SELECT * FROM `{$db_2016}`.`base_regions`"));

    	$this->comment("candidates");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`candidates`"));
        $candidates2016 = DB::select("SELECT * FROM `{$db_2016}`.`candidates`");
        $candidate = [];
        foreach ($candidates2016 AS $candidate2016) {
    		$this->comment(" {$candidate2016->id}");
         	foreach ($candidate2016 AS $key=>$value) {
				switch ($key) {
					case "gd_in_list":
					case "regparlament":
					case "state_cap":
					case "other_omsu":
						break;
					default:
						$candidate[$key] = $value;
						break;
				} // switch
			} // foreach
			DB::table("{$db}.candidates")->insert($candidate);
        }
   		$this->comment("ok");

    	$this->comment("candidate_activities");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`candidate_activities`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`candidate_activities` SELECT * FROM `{$db_2016}`.`candidate_activities`"));
   		$this->comment("ok");

    	$this->comment("candidate_comments");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`candidate_comments`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`candidate_comments` SELECT * FROM `{$db_2016}`.`candidate_comments`"));
   		$this->comment("ok");

   		//**************************************************
   		// Всех кандидатов, округа привязываю к выборам id=1
   		//**************************************************
    	$this->comment("election_okrugs");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`election_okrugs`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`election_okrugs` (`id`, `name`, `detail`, `id_election`) SELECT `id`, `name`, `detail`, 1 AS `id_election` FROM `{$db_2016}`.`okrug`"));
   		$this->comment("ok");

    	$this->comment("candidate_elections");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`candidate_elections`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`candidate_elections` (`id_election`, `id_candidate`, `list_position`) SELECT 1 AS `id_election`, c.`id` AS `id_candidate`, c.`gd_in_list` AS `list_position` FROM `{$db_2016}`.`candidates` c"));
   		$this->comment("ok");

    	$this->comment("elections");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`elections`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`elections` (`id`, `region`, `group`, `name`, `have_okrugs`) VALUES ('1', '', '', '╨Т╤Л╨▒╨╛╤А╤Л ╨▓ ╨У╨╛╤Б╨Ф╤Г╨╝╤Г', '1')"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`elections` (`id`,`region`,`name`,`group`) SELECT `id`+1 AS `id`,`region`,`name`,`group` FROM `{$db_2016}`.`elections`"));
   		$this->comment("ok");
   		//*******************************************************************************************************************


    	$this->comment("candidate_election_okrugs");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`candidate_election_okrugs`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`candidate_election_okrugs` (`id_election_okrug`, `id_candidate`, `id_election`) SELECT o.`id_okrug` AS `id_election_okrug`, o.`id_candidate`, 1 AS `id_election` FROM `{$db_2016}`.`candidate_gd_in_1okrugs` o"));
   		$this->comment("ok");

    	$this->comment("experts");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`experts`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`experts` SELECT * FROM `{$db_2016}`.`experts`"));
   		$this->comment("ok");

    	$this->comment("expert_activities");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`expert_activities`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`expert_activities` SELECT * FROM `{$db_2016}`.`expert_activities`"));
   		$this->comment("ok");

    	$this->comment("expert_hrefs");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`expert_hrefs`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`expert_hrefs` SELECT * FROM `{$db_2016}`.`expert_hrefs`"));
   		$this->comment("ok");

    	$this->comment("show_fields");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`show_fields`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`show_fields` (`name_table`, `field`, `visible`, `name`, `order`, `order_by`, `active`) SELECT `name_table`, `field`, `visible`, `name`, `order`, `order_by`, 1 AS `active` FROM `{$db_2016}`.`show_fields`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`show_fields` (`id`, `name_table`, `field`, `visible`, `name`, `order`, `order_by`, `active`) VALUES (NULL, 'candidates', 'region', '1', 'Регион', '2', 'base_regions.name', '1')"));
   		$this->comment("ok");
   	    
    	$this->comment("statuses");
        DB::statement(DB::raw("TRUNCATE TABLE `{$db}`.`statuses`"));
        DB::statement(DB::raw("INSERT INTO `{$db}`.`statuses` SELECT * FROM `{$db_2016}`.`statuses` WHERE `id`!=0"));
		DB::table("{$db}.statuses")->insert(["id"=>"0", "name"=>"", "name_table"=>"candidates"]);
   		$this->comment("ok");

    }
}

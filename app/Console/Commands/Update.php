<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Schema;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ACTUAL UPDATE DATA inline';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $db      = "inline";

        $this->comment($this->description);
        // Добавляю поле адрес candidates.address
    	if (!Schema::hasColumn("candidates", 'address')) {
	    	$this->comment("candidates.address: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `address` VARCHAR(400)"));
        	DB::statement(DB::raw("UPDATE `{$db}`.`candidates` SET `address`=''"));
        	$order = DB::table("{$db}.show_fields")->select(DB::raw("MAX(`order`)+1 AS value"))->where("name_table", "=", "candidates")->first();
        	DB::statement(DB::raw("
        	   INSERT INTO `{$db}`.`show_fields`
        	   (`name`, `name_table`, `field`, `order`, `visible`, `active`)
        	   VALUES
        	   ('Адрес', 'candidates', 'address', '{$order->value}', 1, 1)
        	"));
    	}

   		$this->comment("ok");

    }
}

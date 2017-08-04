<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Schema;

class Update2017 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update2017';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UPDATE DATA inline';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $db      = "inline";

        $this->comment($this->description);
    	if (!Schema::hasColumn("statuses", 'id_election')) {
	    	$this->comment("statuses.id_election: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`statuses` ADD `id_election` INT(11) DEFAULT 0"));
        	DB::statement(DB::raw("UPDATE `{$db}`.`statuses` SET `id_election`=1"));
    	}

    	if (!Schema::hasColumn("candidate_elections", 'id_status')) {
	    	$this->comment("candidate_elections.id_status: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidate_elections` ADD `id_status` INT(11) DEFAULT 0 COMMENT 'Статус'"));
        	DB::statement(DB::raw("UPDATE `{$db}`.`candidate_elections` ce, `candidates` c SET ce.`id_status`=c.`id_status` WHERE c.`id`=ce.`id_candidate` AND ce.`id_election`=1"));
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` DROP `id_status`"));
        	
    	}

    	if (!Schema::hasColumn("candidate_elections", 'speaker')) {
	    	$this->comment("candidate_elections.speaker: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidate_elections` ADD `speaker` TEXT COMMENT 'Ответственный за ведение переговоров от Яблока'"));
        	DB::statement(DB::raw("UPDATE `{$db}`.`candidate_elections` ce, `candidates` c SET ce.`speaker`=c.`speaker` WHERE c.`id`=ce.`id_candidate` AND ce.`id_election`=1"));
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` DROP `speaker`"));
    	}

    	if (!Schema::hasColumn("candidate_elections", 'speaker_info')) {
	    	$this->comment("candidate_elections.speaker_info: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidate_elections` ADD `speaker_info` TEXT COMMENT 'Информация о ходе переговоров'"));
        	DB::statement(DB::raw("UPDATE `{$db}`.`candidate_elections` ce, `candidates` c SET ce.`speaker_info`=c.`speaker_info` WHERE c.`id`=ce.`id_candidate` AND ce.`id_election`=1"));
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` DROP `speaker_info`"));
    	}

    	if (!Schema::hasColumn("candidate_elections", 'speaker_itog')) {
	    	$this->comment("candidate_elections.speaker_itog: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidate_elections` ADD `speaker_itog` TEXT COMMENT 'Итог переговоров'"));
        	DB::statement(DB::raw("UPDATE `{$db}`.`candidate_elections` ce, `candidates` c SET ce.`speaker_itog`=c.`speaker_itog` WHERE c.`id`=ce.`id_candidate` AND ce.`id_election`=1"));
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` DROP `speaker_itog`"));
    	}

    	if (!Schema::hasColumn("candidates", 'ups')) {
	    	$this->comment("candidates.ups: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `ups` LONGTEXT COMMENT 'УПС'"));
        	DB::statement(DB::raw("
        	 UPDATE 
        	  `{$db}`.`candidates` 
        	 SET
        	  `ups` = CONCAT
        	   (
        	     IF(`ocen_activ_in_party` = '', '' , CONCAT('Активность кандидата в партии:\n', `ocen_activ_in_party`, '\n')),
        	     IF(`ocen_famous_local` = '', '' , CONCAT('Известность кандидата среди избирателей на предполагаемой территории участия в выборах:\n', `ocen_famous_local`, '\n')),
        	     IF(`ocen_famous_region` = '', '' , CONCAT('Известность кандидата в регионе в целом:\n', `ocen_famous_region`, '\n')),
        	     IF(`ocen_exp_gos` = '', '' , CONCAT('Опыт работы в органах власти и МСУ:\n', `ocen_famous_region`, '\n')),
        	     IF(`ocen_exp_election` = '', '' , CONCAT('Опыт участия в выборах в качестве кандидата или организатора выборов:\n', `ocen_exp_election`, '\n')),
        	     IF(`ocen_smi_famous` = '', '' , CONCAT('Упоминаемость кандидата в СМИ и социальных сетях:\n', `ocen_smi_famous`, '\n')),
        	     IF(`ocen_bio_famous` = '', '' , CONCAT('Электоральная привлекательность биографии кандидата:\n', `ocen_bio_famous`, '\n')),
        	     IF(`ocen_social` = '', '' , CONCAT('Социальные связи:\n', `ocen_social`, '\n')),
        	     IF(`ocen_pop_activ` = '', '' , CONCAT('Общественная активность:\n', `ocen_pop_activ`, '\n')),
        	     IF(`ocen_elect_obsh` = '', '' , CONCAT('Участие в работе значимых общественных организаций:\n', `ocen_elect_obsh`, '\n')),
        	     IF(`ocen_position_memorandum` = '', '' , CONCAT('Политическая позиция по ключевым вопросам Меморандума:\n', `ocen_position_memorandum`, '\n')),
        	     IF(`ocen_polit_reput` = '', '' , CONCAT('Политическая репутация (в т.ч. наличие негативной информации):\n', `ocen_polit_reput`, '\n')),
        	     IF(`ocen_rel_yabloko` = '', '' , CONCAT('Отношения в прошлом и настоящем с партией ЯБЛОКО:\n', `ocen_rel_yabloko`, '\n')),
        	     IF(`ocen_rel_parties` = '', '' , CONCAT('Отношения в прошлом и настоящем с иными политическим партиями и движениями:\n', `ocen_rel_parties`, '\n')),
        	     IF(`ocen_skills` = '', '' , CONCAT('Оценка навыков публичных выступлений у кандидата и его харизмы:\n', `ocen_skills`, '\n')),
        	     IF(`ocen_relations` = '', '' , CONCAT('Оценка отношений с местной, региональной или федеральной властью:\n', `ocen_relations`, '\n')),
        	     IF(`ocen_safety` = '', '' , CONCAT('Оценка надежности кандидата в случае избрания депутатом:\n', `ocen_safety`, '\n')),
        	     IF(`ocen_purpose` = '', '' , CONCAT('Оценка целеустремленности кандидата в победе на выборах:\n', `ocen_purpose`, '\n')),
        	     IF(`ocen_finance_res` = '', '' , CONCAT('Финансовые ресурсы:\n', `ocen_finance_res`, '\n')),
        	     IF(`ocen_info_res` = '', '' , CONCAT('Информационные ресурсы:\n', `ocen_info_res`, '\n')),
        	     IF(`ocen_org_res` = '', '' , CONCAT('Организационные ресурсы:\n', `ocen_org_res`, '\n')),
        	     IF(`ocen_dop_info` = '', '' , CONCAT('Дополнительная информация о кандидате:\n', `ocen_dop_info`, '\n')),
        	     IF(`ocen_negative` = '', '' , CONCAT('Негативная информация:\n', `ocen_negative`, '\n'))
        	     
        	   )
        	"));
        	DB::statement(DB::raw("
        	 ALTER TABLE 
        	  `{$db}`.`candidates` 
        	 DROP `ocen_activ_in_party`,
        	 DROP `ocen_famous_local`,
        	 DROP `ocen_famous_region`,
        	 DROP `ocen_exp_gos`,
        	 DROP `ocen_exp_election`,
        	 DROP `ocen_smi_famous`,
        	 DROP `ocen_bio_famous`,
        	 DROP `ocen_social`,
        	 DROP `ocen_pop_activ`,
        	 DROP `ocen_elect_obsh`,
        	 DROP `ocen_position_memorandum`,
        	 DROP `ocen_polit_reput`,
        	 DROP `ocen_rel_yabloko`,
        	 DROP `ocen_rel_parties`,
        	 DROP `ocen_skills`,
        	 DROP `ocen_relations`,
        	 DROP `ocen_safety`,
        	 DROP `ocen_purpose`,
        	 DROP `ocen_finance_res`,
        	 DROP `ocen_info_res`,
        	 DROP `ocen_org_res`,
        	 DROP `ocen_dop_info`,
        	 DROP `ocen_negative`
        	"));
    	}

    	if (!Schema::hasColumn("candidates", 'auy')) {
	    	$this->comment("candidates.auy: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `auy` LONGTEXT COMMENT 'ЭАУ'"));
        	DB::statement(DB::raw("
        	 UPDATE 
        	  `{$db}`.`candidates` 
        	 SET
        	  `auy` = CONCAT
        	   (
        	     IF(`ocen_activ_in_party_2` = '', '' , CONCAT('Активность кандидата в партии:\n', `ocen_activ_in_party_2`, '\n')),
        	     IF(`ocen_famous_local_2` = '', '' , CONCAT('Известность кандидата среди избирателей на предполагаемой территории участия в выборах:\n', `ocen_famous_local_2`, '\n')),
        	     IF(`ocen_famous_region_2` = '', '' , CONCAT('Известность кандидата в регионе в целом:\n', `ocen_famous_region_2`, '\n')),
        	     IF(`ocen_exp_gos_2` = '', '' , CONCAT('Опыт работы в органах власти и МСУ:\n', `ocen_famous_region_2`, '\n')),
        	     IF(`ocen_exp_election_2` = '', '' , CONCAT('Опыт участия в выборах в качестве кандидата или организатора выборов:\n', `ocen_exp_election_2`, '\n')),
        	     IF(`ocen_smi_famous_2` = '', '' , CONCAT('Упоминаемость кандидата в СМИ и социальных сетях:\n', `ocen_smi_famous_2`, '\n')),
        	     IF(`ocen_bio_famous_2` = '', '' , CONCAT('Электоральная привлекательность биографии кандидата:\n', `ocen_bio_famous_2`, '\n')),
        	     IF(`ocen_social_2` = '', '' , CONCAT('Социальные связи:\n', `ocen_social_2`, '\n')),
        	     IF(`ocen_pop_activ_2` = '', '' , CONCAT('Общественная активность:\n', `ocen_pop_activ_2`, '\n')),
        	     IF(`ocen_elect_obsh_2` = '', '' , CONCAT('Участие в работе значимых общественных организаций:\n', `ocen_elect_obsh_2`, '\n')),
        	     IF(`ocen_position_memorandum_2` = '', '' , CONCAT('Политическая позиция по ключевым вопросам Меморандума:\n', `ocen_position_memorandum_2`, '\n')),
        	     IF(`ocen_polit_reput_2` = '', '' , CONCAT('Политическая репутация (в т.ч. наличие негативной информации):\n', `ocen_polit_reput_2`, '\n')),
        	     IF(`ocen_rel_yabloko_2` = '', '' , CONCAT('Отношения в прошлом и настоящем с партией ЯБЛОКО:\n', `ocen_rel_yabloko_2`, '\n')),
        	     IF(`ocen_rel_parties_2` = '', '' , CONCAT('Отношения в прошлом и настоящем с иными политическим партиями и движениями:\n', `ocen_rel_parties_2`, '\n')),
        	     IF(`ocen_skills_2` = '', '' , CONCAT('Оценка навыков публичных выступлений у кандидата и его харизмы:\n', `ocen_skills_2`, '\n')),
        	     IF(`ocen_relations_2` = '', '' , CONCAT('Оценка отношений с местной, региональной или федеральной властью:\n', `ocen_relations_2`, '\n')),
        	     IF(`ocen_safety_2` = '', '' , CONCAT('Оценка надежности кандидата в случае избрания депутатом:\n', `ocen_safety_2`, '\n')),
        	     IF(`ocen_purpose_2` = '', '' , CONCAT('Оценка целеустремленности кандидата в победе на выборах:\n', `ocen_purpose_2`, '\n')),
        	     IF(`ocen_finance_res_2` = '', '' , CONCAT('Финансовые ресурсы:\n', `ocen_finance_res_2`, '\n')),
        	     IF(`ocen_info_res_2` = '', '' , CONCAT('Информационные ресурсы:\n', `ocen_info_res_2`, '\n')),
        	     IF(`ocen_org_res_2` = '', '' , CONCAT('Организационные ресурсы:\n', `ocen_org_res_2`, '\n')),
        	     IF(`ocen_dop_info_2` = '', '' , CONCAT('Дополнительная информация о кандидате:\n', `ocen_dop_info_2`, '\n')),
        	     IF(`ocen_negative_2` = '', '' , CONCAT('Негативная информация:\n', `ocen_negative_2`, '\n'))
        	   )
        	"));
        	DB::statement(DB::raw("
        	 ALTER TABLE 
        	  `{$db}`.`candidates` 
        	 DROP `ocen_activ_in_party_2`,
        	 DROP `ocen_famous_local_2`,
        	 DROP `ocen_famous_region_2`,
        	 DROP `ocen_exp_gos_2`,
        	 DROP `ocen_exp_election_2`,
        	 DROP `ocen_smi_famous_2`,
        	 DROP `ocen_bio_famous_2`,
        	 DROP `ocen_social_2`,
        	 DROP `ocen_pop_activ_2`,
        	 DROP `ocen_elect_obsh_2`,
        	 DROP `ocen_position_memorandum_2`,
        	 DROP `ocen_polit_reput_2`,
        	 DROP `ocen_rel_yabloko_2`,
        	 DROP `ocen_rel_parties_2`,
        	 DROP `ocen_skills_2`,
        	 DROP `ocen_relations_2`,
        	 DROP `ocen_safety_2`,
        	 DROP `ocen_purpose_2`,
        	 DROP `ocen_finance_res_2`,
        	 DROP `ocen_info_res_2`,
        	 DROP `ocen_org_res_2`,
        	 DROP `ocen_dop_info_2`,
        	 DROP `ocen_negative_2`
        	"));
    	}

    	if (!Schema::hasColumn("candidates", 'urs')) {
	    	$this->comment("candidates.urs: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `urs` LONGTEXT COMMENT 'УРС'"));
        	DB::statement(DB::raw("
        	 UPDATE 
        	  `{$db}`.`candidates` 
        	 SET
        	  `urs` = CONCAT
        	   (
        	     IF(`ocen_activ_in_party_3` = '', '' , CONCAT('Активность кандидата в партии:\n', `ocen_activ_in_party_3`, '\n')),
        	     IF(`ocen_famous_local_3` = '', '' , CONCAT('Известность кандидата среди избирателей на предполагаемой территории участия в выборах:\n', `ocen_famous_local_3`, '\n')),
        	     IF(`ocen_famous_region_3` = '', '' , CONCAT('Известность кандидата в регионе в целом:\n', `ocen_famous_region_3`, '\n')),
        	     IF(`ocen_exp_gos_3` = '', '' , CONCAT('Опыт работы в органах власти и МСУ:\n', `ocen_famous_region_3`, '\n')),
        	     IF(`ocen_exp_election_3` = '', '' , CONCAT('Опыт участия в выборах в качестве кандидата или организатора выборов:\n', `ocen_exp_election_3`, '\n')),
        	     IF(`ocen_smi_famous_3` = '', '' , CONCAT('Упоминаемость кандидата в СМИ и социальных сетях:\n', `ocen_smi_famous_3`, '\n')),
        	     IF(`ocen_bio_famous_3` = '', '' , CONCAT('Электоральная привлекательность биографии кандидата:\n', `ocen_bio_famous_3`, '\n')),
        	     IF(`ocen_social_3` = '', '' , CONCAT('Социальные связи:\n', `ocen_social_3`, '\n')),
        	     IF(`ocen_pop_activ_3` = '', '' , CONCAT('Общественная активность:\n', `ocen_pop_activ_3`, '\n')),
        	     IF(`ocen_elect_obsh_3` = '', '' , CONCAT('Участие в работе значимых общественных организаций:\n', `ocen_elect_obsh_3`, '\n')),
        	     IF(`ocen_position_memorandum_3` = '', '' , CONCAT('Политическая позиция по ключевым вопросам Меморандума:\n', `ocen_position_memorandum_3`, '\n')),
        	     IF(`ocen_polit_reput_3` = '', '' , CONCAT('Политическая репутация (в т.ч. наличие негативной информации):\n', `ocen_polit_reput_3`, '\n')),
        	     IF(`ocen_rel_yabloko_3` = '', '' , CONCAT('Отношения в прошлом и настоящем с партией ЯБЛОКО:\n', `ocen_rel_yabloko_3`, '\n')),
        	     IF(`ocen_rel_parties_3` = '', '' , CONCAT('Отношения в прошлом и настоящем с иными политическим партиями и движениями:\n', `ocen_rel_parties_3`, '\n')),
        	     IF(`ocen_skills_3` = '', '' , CONCAT('Оценка навыков публичных выступлений у кандидата и его харизмы:\n', `ocen_skills_3`, '\n')),
        	     IF(`ocen_relations_3` = '', '' , CONCAT('Оценка отношений с местной, региональной или федеральной властью:\n', `ocen_relations_3`, '\n')),
        	     IF(`ocen_safety_3` = '', '' , CONCAT('Оценка надежности кандидата в случае избрания депутатом:\n', `ocen_safety_3`, '\n')),
        	     IF(`ocen_purpose_3` = '', '' , CONCAT('Оценка целеустремленности кандидата в победе на выборах:\n', `ocen_purpose_3`, '\n')),
        	     IF(`ocen_finance_res_3` = '', '' , CONCAT('Финансовые ресурсы:\n', `ocen_finance_res_3`, '\n')),
        	     IF(`ocen_info_res_3` = '', '' , CONCAT('Информационные ресурсы:\n', `ocen_info_res_3`, '\n')),
        	     IF(`ocen_org_res_3` = '', '' , CONCAT('Организационные ресурсы:\n', `ocen_org_res_3`, '\n')),
        	     IF(`ocen_dop_info_3` = '', '' , CONCAT('Дополнительная информация о кандидате:\n', `ocen_dop_info_3`, '\n')),
        	     IF(`ocen_negative_3` = '', '' , CONCAT('Негативная информация:\n', `ocen_negative_3`, '\n'))
        	   )
        	"));
        	DB::statement(DB::raw("
        	 ALTER TABLE 
        	  `{$db}`.`candidates` 
        	 DROP `ocen_activ_in_party_3`,
        	 DROP `ocen_famous_local_3`,
        	 DROP `ocen_famous_region_3`,
        	 DROP `ocen_exp_gos_3`,
        	 DROP `ocen_exp_election_3`,
        	 DROP `ocen_smi_famous_3`,
        	 DROP `ocen_bio_famous_3`,
        	 DROP `ocen_social_3`,
        	 DROP `ocen_pop_activ_3`,
        	 DROP `ocen_elect_obsh_3`,
        	 DROP `ocen_position_memorandum_3`,
        	 DROP `ocen_polit_reput_3`,
        	 DROP `ocen_rel_yabloko_3`,
        	 DROP `ocen_rel_parties_3`,
        	 DROP `ocen_skills_3`,
        	 DROP `ocen_relations_3`,
        	 DROP `ocen_safety_3`,
        	 DROP `ocen_purpose_3`,
        	 DROP `ocen_finance_res_3`,
        	 DROP `ocen_info_res_3`,
        	 DROP `ocen_org_res_3`,
        	 DROP `ocen_dop_info_3`,
        	 DROP `ocen_negative_3`
        	"));
    	}

    	if (!Schema::hasColumn("candidates", 'uv')) {
	    	$this->comment("candidates.uv: FIELD ADDED");
        	DB::statement(DB::raw("ALTER TABLE `{$db}`.`candidates` ADD `uv` LONGTEXT COMMENT 'УВ'"));
        	DB::statement(DB::raw("
        	 UPDATE 
        	  `{$db}`.`candidates` 
        	 SET
        	  `uv` = CONCAT
        	   (
        	     IF(`ocen_activ_in_party_4` = '', '' , CONCAT('Активность кандидата в партии:\n', `ocen_activ_in_party_4`, '\n')),
        	     IF(`ocen_famous_local_4` = '', '' , CONCAT('Известность кандидата среди избирателей на предполагаемой территории участия в выборах:\n', `ocen_famous_local_4`, '\n')),
        	     IF(`ocen_famous_region_4` = '', '' , CONCAT('Известность кандидата в регионе в целом:\n', `ocen_famous_region_4`, '\n')),
        	     IF(`ocen_exp_gos_4` = '', '' , CONCAT('Опыт работы в органах власти и МСУ:\n', `ocen_famous_region_4`, '\n')),
        	     IF(`ocen_exp_election_4` = '', '' , CONCAT('Опыт участия в выборах в качестве кандидата или организатора выборов:\n', `ocen_exp_election_4`, '\n')),
        	     IF(`ocen_smi_famous_4` = '', '' , CONCAT('Упоминаемость кандидата в СМИ и социальных сетях:\n', `ocen_smi_famous_4`, '\n')),
        	     IF(`ocen_bio_famous_4` = '', '' , CONCAT('Электоральная привлекательность биографии кандидата:\n', `ocen_bio_famous_4`, '\n')),
        	     IF(`ocen_social_4` = '', '' , CONCAT('Социальные связи:\n', `ocen_social_4`, '\n')),
        	     IF(`ocen_pop_activ_4` = '', '' , CONCAT('Общественная активность:\n', `ocen_pop_activ_4`, '\n')),
        	     IF(`ocen_elect_obsh_4` = '', '' , CONCAT('Участие в работе значимых общественных организаций:\n', `ocen_elect_obsh_4`, '\n')),
        	     IF(`ocen_position_memorandum_4` = '', '' , CONCAT('Политическая позиция по ключевым вопросам Меморандума:\n', `ocen_position_memorandum_4`, '\n')),
        	     IF(`ocen_polit_reput_4` = '', '' , CONCAT('Политическая репутация (в т.ч. наличие негативной информации):\n', `ocen_polit_reput_4`, '\n')),
        	     IF(`ocen_rel_yabloko_4` = '', '' , CONCAT('Отношения в прошлом и настоящем с партией ЯБЛОКО:\n', `ocen_rel_yabloko_4`, '\n')),
        	     IF(`ocen_rel_parties_4` = '', '' , CONCAT('Отношения в прошлом и настоящем с иными политическим партиями и движениями:\n', `ocen_rel_parties_4`, '\n')),
        	     IF(`ocen_skills_4` = '', '' , CONCAT('Оценка навыков публичных выступлений у кандидата и его харизмы:\n', `ocen_skills_4`, '\n')),
        	     IF(`ocen_relations_4` = '', '' , CONCAT('Оценка отношений с местной, региональной или федеральной властью:\n', `ocen_relations_4`, '\n')),
        	     IF(`ocen_safety_4` = '', '' , CONCAT('Оценка надежности кандидата в случае избрания депутатом:\n', `ocen_safety_4`, '\n')),
        	     IF(`ocen_purpose_4` = '', '' , CONCAT('Оценка целеустремленности кандидата в победе на выборах:\n', `ocen_purpose_4`, '\n')),
        	     IF(`ocen_finance_res_4` = '', '' , CONCAT('Финансовые ресурсы:\n', `ocen_finance_res_4`, '\n')),
        	     IF(`ocen_info_res_4` = '', '' , CONCAT('Информационные ресурсы:\n', `ocen_info_res_4`, '\n')),
        	     IF(`ocen_org_res_4` = '', '' , CONCAT('Организационные ресурсы:\n', `ocen_org_res_4`, '\n')),
        	     IF(`ocen_dop_info_4` = '', '' , CONCAT('Дополнительная информация о кандидате:\n', `ocen_dop_info_4`, '\n')),
        	     IF(`ocen_negative_4` = '', '' , CONCAT('Негативная информация:\n', `ocen_negative_4`, '\n'))
        	   )
        	"));
        	DB::statement(DB::raw("
        	 ALTER TABLE 
        	  `{$db}`.`candidates` 
        	 DROP `ocen_activ_in_party_4`,
        	 DROP `ocen_famous_local_4`,
        	 DROP `ocen_famous_region_4`,
        	 DROP `ocen_exp_gos_4`,
        	 DROP `ocen_exp_election_4`,
        	 DROP `ocen_smi_famous_4`,
        	 DROP `ocen_bio_famous_4`,
        	 DROP `ocen_social_4`,
        	 DROP `ocen_pop_activ_4`,
        	 DROP `ocen_elect_obsh_4`,
        	 DROP `ocen_position_memorandum_4`,
        	 DROP `ocen_polit_reput_4`,
        	 DROP `ocen_rel_yabloko_4`,
        	 DROP `ocen_rel_parties_4`,
        	 DROP `ocen_skills_4`,
        	 DROP `ocen_relations_4`,
        	 DROP `ocen_safety_4`,
        	 DROP `ocen_purpose_4`,
        	 DROP `ocen_finance_res_4`,
        	 DROP `ocen_info_res_4`,
        	 DROP `ocen_org_res_4`,
        	 DROP `ocen_dop_info_4`,
        	 DROP `ocen_negative_4`
        	 
        	"));
    	}

    	if (Schema::hasColumn('candidates', 'old_id')) {
	    	$this->comment("candidates.old_id: DROP FIELD");
        	DB::statement(DB::raw("
        	 ALTER TABLE 
        	  `{$db}`.`candidates` 
        	 DROP `old_id`
        	"));
    	}

    	if (Schema::hasColumn("candidates", 'notice')) {
   			$this->comment("information");
        	DB::statement(DB::raw("
        	 UPDATE 
        	  `{$db}`.`candidates` 
        	 SET
        	  `information` = CONCAT
        	   (
        	     IF(`information` = '', '' , CONCAT('Справка:\n', `information`, '\n')),
        	     IF(`notice` = '', '' , CONCAT('Примечание:\n', `notice`, '\n')),
        	     IF(`speaker_dopinfo` = '', '' , CONCAT('Какую дополнительно информацию о кандидате вы считаете важным сообщить:\n', `speaker_dopinfo`, '\n'))
        	   )
        	"));

        	DB::statement(DB::raw("
        	 ALTER TABLE 
        	  `{$db}`.`candidates` 
        	 DROP `notice`,
        	 DROP `speaker_dopinfo`
        	"));
    	}


    	$status = DB::table("{$db}.statuses")->select("id")->where("name_table", "=", "candidates")->where("name", "=", "Подготовлен к выдвижению")->first();
    	if (!$status) {
   			$this->comment("change statuses");
        	DB::statement(DB::raw("
        	   INSERT INTO `{$db}`.`statuses`
        	   (`name`, `name_table`, `id_election`)
        	   VALUES
        	   ('Подготовлен к выдвижению', 'candidates', '1')
        	"));
    	}
    	$status = DB::table("{$db}.statuses")->select("id")->where("name_table", "=", "candidates")->where("name", "=", "Подготовлен к выдвижению")->first();

    	$query = "
    	          UPDATE
    	           `candidate_elections`
    	          SET
    	           `id_status` = '{$status->id}'
    	          WHERE
    	           `id_status` IN (5,6,7,8)
    	";
       	DB::statement(DB::raw($query));
       	DB::statement(DB::raw("DELETE FROM {$db}.`statuses` WHERE `id` IN (5,6,7,8)"));

   		$this->comment("clear show_fields");
        $show_fields = DB::select("SELECT * FROM `{$db}`.`show_fields` WHERE `name_table`='candidates'");
        foreach ($show_fields AS $show_field) {
            // Если нет такого поля, и это не поле region
			if (!Schema::hasColumn("candidates", $show_field->field) and $show_field->id != 123) {
		   		$this->comment(" DROP SHOW_FIELD {$show_field->field}");
       			DB::statement(DB::raw("DELETE FROM `{$db}`.`show_fields` WHERE `id`= {$show_field->id}"));
			}
        }

   		$this->comment("ok");

    }
}

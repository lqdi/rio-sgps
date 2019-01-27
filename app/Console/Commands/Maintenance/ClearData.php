<?php
/**
 * rio-sgps
 * ClearData.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 22:53
 */

namespace SGPS\Console\Commands\Maintenance;


use DB;
use Illuminate\Console\Command;

class ClearData extends Command {

	protected $signature = 'maintenance:clear_data';

	public function handle() {

		if(app()->environment() !== 'local') {
			$this->error("This command can only be run on local dev environments!");
		}

		if($this->confirm('Should FAMILY DATA be deleted?', true)) {
			$this->info("Truncating tables...");

			DB::statement('TRUNCATE TABLE families');
			DB::statement('TRUNCATE TABLE residences');
			DB::statement('TRUNCATE TABLE persons');
			DB::statement('TRUNCATE TABLE user_assignments');
			DB::statement('TRUNCATE TABLE question_answers');
			DB::statement('TRUNCATE TABLE flag_attributions');

			$this->info("Tables truncated!");
		}

		if($this->confirm('Should SECTOR and EQUIPMENT DATA be deleted?', false)) {
			$this->info("Truncating tables...");

			DB::statement('TRUNCATE TABLE user_equipments');
			DB::statement('TRUNCATE TABLE equipments');
			DB::statement('TRUNCATE TABLE sectors');
			DB::statement('TRUNCATE TABLE sector_equipments');

			$this->info("Tables truncated!");
		}

		$this->info("DATA CLEAR COMPLETE!");

	}

}
<?php
/**
 * rio-sgps
 * InstallSampleData.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/10/2018, 20:14
 */

namespace SGPS\Console\Commands\Maintenance;


use DB;
use Illuminate\Console\Command;

class InstallSampleData extends Command {

	protected $signature = 'install:sample_data';
	protected $description = 'Imports sample data to the system';

	public function handle() {

		if($this->confirm('ERASE all existing entity data (families, residences, persons, user assignments, user equipments, sectors, answers and flag attribs)?', false)) {
			$this->delete_existing_data();
		}

		$this->install_sample_data();

	}

	public function delete_existing_data() {
		$this->info("Truncating tables...");

		DB::statement('TRUNCATE TABLE families');
		DB::statement('TRUNCATE TABLE residences');
		DB::statement('TRUNCATE TABLE persons');
		DB::statement('TRUNCATE TABLE user_assignments');
		DB::statement('TRUNCATE TABLE user_equipments');
		DB::statement('TRUNCATE TABLE equipments');
		DB::statement('TRUNCATE TABLE sectors');
		DB::statement('TRUNCATE TABLE question_answers');
		DB::statement('TRUNCATE TABLE flag_attributions');

		$this->info("Tables truncated!");
	}

	public function install_sample_data() {

		$this->info("Running sample data seeder...");

		$seeder = new \SampleDataSeeder();
		$seeder->run();

		$this->info("Seeder completed!");

	}

}
<?php
/**
 * rio-sgps
 * InstallInitialData.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/10/2018, 17:53
 */

namespace SGPS\Console\Commands\Maintenance;


use DB;
use Illuminate\Console\Command;
use SGPS\Entity\Flag;
use SGPS\Entity\Group;
use SGPS\Entity\Question;
use SGPS\Entity\QuestionCategory;

class InstallInitialData extends Command {

	public $signature = 'install';
	public $description = 'Installs initial data';

	public function handle() {

		if($this->confirm('ERASE all existing data (groups, questions, answers, flags and flag attribs)?', false)) {
			$this->delete_existing_data();
		}

		$this->info("Installing QUESTIONS...");
		$this->install_questions();

		$this->info("Installing GROUPS...");
		$this->install_groups();

		$this->info("Installing FLAGS...");
		$this->install_flags();

		$this->info("Installation complete!");

	}

	public function delete_existing_data() {
		$this->info("Truncating tables...");

		DB::statement('TRUNCATE TABLE questions');
		DB::statement('TRUNCATE TABLE question_categories');
		DB::statement('TRUNCATE TABLE question_categories_pivot');
		DB::statement('TRUNCATE TABLE question_answers');
		DB::statement('TRUNCATE TABLE flags');
		DB::statement('TRUNCATE TABLE flag_groups');
		DB::statement('TRUNCATE TABLE flag_attributions');

		$this->info("Tables truncated!");
	}

	public function install_questions() {
		$questions = config('initial_questions.questions');

		$map = config('initial_questions.category_map');
		$categoryNames = config('initial_questions.categories');

		$qdb = collect([]);
		$catdb = collect($categoryNames)
			->keys()
			->mapWithKeys(function ($key, $_) {
				return [$key => collect([])];
			});

		foreach($questions as $code => $q) {
			$qdb[$code] = new Question();
			$qdb[$code]->fill($q);
			$qdb[$code]->key = $code;
		}

		foreach($map as $entityType => $categoryMap) {
			foreach($categoryMap as $categoryKey => $questionCodes) {

				$catdb[$categoryKey] = $catdb[$categoryKey]->merge($questionCodes);

				foreach($questionCodes as $code) {
					$qdb[$code]->entity_type = $entityType;
					$qdb[$code]->save();
				}
			}
		}

		foreach($catdb as $categoryKey => $questionCodes) {

			$category = new QuestionCategory();
			$category->name = $categoryNames[$categoryKey] ?? $categoryKey;
			$category->save();

			$questionIDs = $questionCodes
				->map(function ($code) use ($qdb) {
					return $qdb[$code]->id;
				})
				->toArray();

			$category->questions()->sync($questionIDs);

		}
	}

	public function install_groups() {
		$groups = config('initial_groups');

		foreach($groups as $data) {
			Group::create([
				'code' => $data['code'],
				'name' => $data['name'],
			]);
		}
	}

	public function install_flags() {
		$flags = config('initial_flags');

		foreach($flags as $code => $data) {
			$flag = Flag::create([
				'code' => $data['code'],
				'entity_type' => $data['entity_type'],
				'name' => $data['name'],
				'behavior' => $data['behavior'],
				'conditions' => $data['conditions'],
				'is_visible' => true,
				'default_deadline' => 30,
			]); /* @var $flag Flag */

			$flag->groups()->sync($data['groups']);
		}
	}

}
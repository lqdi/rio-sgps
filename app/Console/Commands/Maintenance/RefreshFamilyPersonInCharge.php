<?php
/**
 * rio-sgps
 * RefreshFamilyPersonInCharge.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 19/02/2019, 22:16
 */

namespace SGPS\Console\Commands\Maintenance;


use Illuminate\Console\Command;
use SGPS\Entity\Family;

class RefreshFamilyPersonInCharge extends Command {

	protected $signature = 'maintenance:refresh_family_person_in_charge';

	public function handle() {

		$families = Family::all(); /* @var $families \SGPS\Entity\Family[] */

		$familiesFixed = 0;

		$this->info("Processing {$families->count()} families...");

		foreach($families as $family) {
			$this->comment("Checking: #{$family->shortcode}...");

			if($family->person_in_charge_id) continue;

			$personInCharge = $family->members
				->first(function ($member) { /* @var $member \SGPS\Entity\Person */
					$answer = $member->getAnswerByCode('CE50');

					if(!$answer) return false;

					return intval($answer->getValue()) === 1;
				});

			if(!$personInCharge) continue;

			$familiesFixed++;

			$this->comment("\tFixed! Person in charge: {$personInCharge->shortcode} / {$personInCharge->name}");

			$family->person_in_charge_id = $personInCharge->id;
			$family->save();
		}

		$this->info("Completed with {$familiesFixed} families fixed!");

	}

}